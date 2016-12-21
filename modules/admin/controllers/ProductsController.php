<?php

namespace app\modules\admin\controllers;

use app\models\CatsForProducts;
use app\models\Characteristics;
use app\models\CharacteristicsData;
use app\models\CharacteristicsForProducts;
use app\models\FilesForProducts;
use app\models\Functions;
use app\models\ProductsTypesForProduct;
use Yii;
use app\models\Products;
use app\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\models\ImagesForProducts;
use app\models\ProductsSort;


/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = 'admin';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $config = [];
        if (Yii::$app->request->get('cat_id')){
            $config['cat_id'] = Yii::$app->request->get('cat_id');
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$config);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
        $functions = new Functions();
        if ($model->load(Yii::$app->request->post())) {
            $model->url =$functions->str2url($model->name);
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->files = UploadedFile::getInstances($model, 'files');
            if ($model->save()){
                if (Yii::$app->request->post('characteristics')){
                    foreach (Yii::$app->request->post('characteristics') as $key => $value) {
                        $model5 = Characteristics::findOne($key);
                        if ($model5){
                            if ($model5->type==0){
                                $model6 = new CharacteristicsData();
                                $model6->parent_id = $key;
                                $model6->name = $value;
                                $model6->save();

                                $model7 = new CharacteristicsForProducts();
                                $model7->product_id = $model->id;
                                $model7->character_data_id = $model6->id;
                                $model7->save();
                            }elseif($model5->type==1){
                                $model7 = new CharacteristicsForProducts();
                                $model7->product_id = $model->id;
                                $model7->character_data_id = $value;
                                $model7->save();
                            }elseif($model5->type==2){
                                foreach ($value as $key2=>$value2) {
                                    $model7 = new CharacteristicsForProducts();
                                    $model7->product_id = $model->id;
                                    $model7->character_data_id = $value2;
                                    $model7->save();
                                }
                            }elseif($model5->type==3){
                                $model7 = new CharacteristicsForProducts();
                                $model7->product_id = $model->id;
                                $model7->character_data_id = $value;
                                $model7->save();
                            }
                        }
                    }

                }
                if ($model->imageFiles){
                    $tmp = $model->upload();
                    if ($tmp){
                        foreach ($tmp  as $key=>$value) {
                            $images_model = new ImagesForProducts();
                            $images_model->url = $value;
                            $images_model->product_id = $model->id;
                            $images_model->save();
                        }
                    }
                }
                if ($model->files){
                    $tmp = $model->upload_files($model->id);
                    if ($tmp){
                        foreach ($tmp  as $key=>$value) {
                            $files_model = new FilesForProducts();
                            $files_model->url = $value;
                            $files_model->product_id = $model->id;
                            $files_model->save();
                        }
                    }
                }
                if (Yii::$app->request->post('cats')){
                    foreach (Yii::$app->request->post('cats') as $key => $value) {
                        $model4 = new CatsForProducts();
                        $model4->cat_id = $value;
                        $model4->product_id = $model->id;
                        $model4->save();
                    }
                }
                if (Yii::$app->request->post('product_types')){
                    $model8 = new ProductsTypesForProduct();
                    $model8->product_id = $model->id;
                    $model8->product_type_id = Yii::$app->request->post('product_types');
                    $model8->save();
                }
            }

            return $this->redirect(['create']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $functions = new Functions();
        if ($model->load(Yii::$app->request->post())) {
            $model->url =$functions->str2url($model->name);
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->files = UploadedFile::getInstances($model, 'files');
            if ($model->save()){
                CatsForProducts::deleteAll(['product_id'=>$model->id]);
                if (Yii::$app->request->post('cats')){
                    foreach (Yii::$app->request->post('cats') as $key => $value) {
                        $model4 = new CatsForProducts();
                        $model4->cat_id = $value;
                        $model4->product_id = $model->id;
                        $model4->save();
                    }
                }
                ProductsTypesForProduct::deleteAll(['product_id'=>$model->id]);
                if (Yii::$app->request->post('product_types')){
                    $model8 = new ProductsTypesForProduct();
                    $model8->product_id = $model->id;
                    $model8->product_type_id = Yii::$app->request->post('product_types');
                    $model8->save();
                }
                if (Yii::$app->request->post('deleteimage')){
                    foreach (Yii::$app->request->post('deleteimage') as $key => $value) {
                        $tmp = ImagesForProducts::findOne($key)->delete();
                    }
                }
                if (Yii::$app->request->post('deletefile')){
                    foreach (Yii::$app->request->post('deletefile') as $key => $value) {
                        $tmp = FilesForProducts::findOne($key)->delete();
                    }
                }
                CharacteristicsForProducts::deleteAll(['product_id'=>$model->id]);
                if (Yii::$app->request->post('characteristics')){
                    foreach (Yii::$app->request->post('characteristics') as $key => $value) {
                        $model5 = Characteristics::findOne($key);
                        if ($model5){
                            if ($model5->type==0){
                                $model6 = new CharacteristicsData();
                                $model6->parent_id = $key;
                                $model6->name = $value;
                                $model6->save();

                                $model7 = new CharacteristicsForProducts();
                                $model7->product_id = $model->id;
                                $model7->character_data_id = $model6->id;
                                $model7->save();
                            }elseif($model5->type==1){
                                $model7 = new CharacteristicsForProducts();
                                $model7->product_id = $model->id;
                                $model7->character_data_id = $value;
                                $model7->save();
                            }elseif($model5->type==2){
                                foreach ($value as $key2=>$value2) {
                                    $model7 = new CharacteristicsForProducts();
                                    $model7->product_id = $model->id;
                                    $model7->character_data_id = $value2;
                                    $model7->save();
                                }
                            }elseif($model5->type==3){
                                $model7 = new CharacteristicsForProducts();
                                $model7->product_id = $model->id;
                                $model7->character_data_id = $value;
                                $model7->save();
                            }
                        }
                    }

                }
                if ($model->imageFiles){
                    $tmp = $model->upload();
                    if ($tmp){
                        foreach ($tmp  as $key=>$value) {
                            $images_model = new ImagesForProducts();
                            $images_model->url = $value;
                            $images_model->product_id = $model->id;
                            $images_model->save();
                        }
                    }
                }
                ImagesForProducts::updateAll(['main_image' => 0],'product_id = '.$model->id);
                if ($model->files){
                    $tmp = $model->upload_files($model->id);
                    if ($tmp){
                        foreach ($tmp  as $key=>$value) {
                            $files_model = new FilesForProducts();
                            $files_model->url = $value;
                            $files_model->product_id = $model->id;
                            $files_model->save();
                        }
                    }
                }
                if (Yii::$app->request->post('mainimage')){
                    ImagesForProducts::updateAll(['main_image'=>1],'id = '.Yii::$app->request->post('mainimage'));
                }

                return $this->redirect(['update', 'id' => $model->id]);
            }


        }
            $images = ImagesForProducts::find()->where(['product_id'=>$model->id])->asArray()->all();
            $files = FilesForProducts::find()->where(['product_id'=>$model->id])->asArray()->all();
            return $this->render('update', [
                'model' => $model,
                'images' => $images,
                'files' => $files,
            ]);
     }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
