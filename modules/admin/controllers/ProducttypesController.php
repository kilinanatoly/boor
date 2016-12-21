<?php

namespace app\modules\admin\controllers;

use app\models\CharacteristicsForProfuctTypes;
use app\models\CharacteristicsSort;
use app\models\ProductTypesForCats;
use Yii;
use app\models\ProductTypes;
use app\models\ProductTypesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductTypesController implements the CRUD actions for ProductTypes model.
 */
class ProducttypesController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lists all ProductTypes models.
     * @return mixed
     */
    public $layout = 'admin';
    public function actionIndex()
    {
        $searchModel = new ProductTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductTypes model.
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
     * Creates a new ProductTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ProductTypes();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()){
                if (Yii::$app->request->post('attributes')){
                    foreach (Yii::$app->request->post('attributes') as $key=>$value) {
                        $model1 = new CharacteristicsForProfuctTypes();
                        $model1->product_type_id = $model->id;
                        $model1->characteristic_id = $value;
                        $model1->save();

                        $model1 = new CharacteristicsSort();
                        $model1->product_type_id = $model->id;
                        $model1->characteristic_id = $value;
                        $model1->sort = 0;
                        $model1->save();
                    }
                }
                if (Yii::$app->request->post('cats')){
                    foreach (Yii::$app->request->post('cats') as $key=>$value) {
                        $model2 = new ProductTypesForCats();
                        $model2->product_type_id = $model->id;
                        $model2->cat_id = $value;
                        $model2->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
            return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing ProductTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()){
                CharacteristicsForProfuctTypes::deleteAll(['product_type_id'=>$model->id]);

                if (Yii::$app->request->post('attributes')){

                    foreach (Yii::$app->request->post('attributes') as $key=>$value) {
                        $model1 = new CharacteristicsForProfuctTypes();
                        $model1->product_type_id = $model->id;
                        $model1->characteristic_id = $value;
                        $model1->save();

                        if (!$model1 = CharacteristicsSort::findOne(['characteristic_id'=>$value])){
                            $model1 = new CharacteristicsSort();
                        }
                        $model1->product_type_id = $model->id;
                        $model1->characteristic_id = $value;
                        $model1->sort = 0;
                        $model1->save();
                    }

                }
                if (Yii::$app->request->post('sort')){
                    foreach (Yii::$app->request->post('sort') as $key=>$value) {
                        if (!$model1 = CharacteristicsSort::findOne(['characteristic_id'=>$key])){
                            $model1 = new CharacteristicsSort();
                        }
                        $model1->product_type_id = $model->id;
                        $model1->characteristic_id = $key;
                        $model1->sort = $value;
                        $model1->save();
                    }


                }

                if (Yii::$app->request->post('attributes1')){
                    foreach (Yii::$app->request->post('attributes1') as $key=>$value) {
                        CharacteristicsForProfuctTypes::deleteAll(['product_type_id'=>$model->id,'characteristic_id'=>$value]);

                    }
                }

                ProductTypesForCats::deleteAll(['product_type_id'=>$model->id]);
                if (Yii::$app->request->post('cats')){
                    foreach (Yii::$app->request->post('cats') as $key=>$value) {
                        $model2 = new ProductTypesForCats();
                        $model2->product_type_id = $model->id;
                        $model2->cat_id = $value;
                        $model2->save();
                    }
                }
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
            return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing ProductTypes model.
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
     * Finds the ProductTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductTypes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductTypes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
