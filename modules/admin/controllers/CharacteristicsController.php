<?php

namespace app\modules\admin\controllers;

use app\models\CharacteristicsData;
use Yii;
use app\models\Characteristics;
use app\models\CharacteristicsSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CharacteristicsController implements the CRUD actions for Characteristics model.
 */
class CharacteristicsController extends Controller
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
     * Lists all Characteristics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CharacteristicsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Characteristics model.
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
     * Creates a new Characteristics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Characteristics();

        if ($model->load(Yii::$app->request->post()) && $model->validate())  {
            if ($model->save()) {
                $last_id = Yii::$app->db->lastInsertID;
                if ($model->type != 0) {
                    if (($characteristics_data = Yii::$app->request->post('characteristics_data')) !== null && ($characteristics_data_sort = Yii::$app->request->post('characteristics_data_sort')) !== null) {
                        foreach ($characteristics_data as $key => $value) {
                            $characteristics_data_model = new CharacteristicsData();
                            $characteristics_data_model->name = $value;
                            $characteristics_data_model->parent_id = $last_id;
                            $characteristics_data_model->sort = ($characteristics_data_sort[$key] ? $characteristics_data_sort[$key] : 0);
                            $characteristics_data_model->save();
                        }


                    }
                } else {
                    $characteristics_data_model = new CharacteristicsData();
                    $characteristics_data_model->name = 'textinput';
                    $characteristics_data_model->parent_id = $last_id;
                    $characteristics_data_model->sort = 0;
                    $characteristics_data_model->save();
                }
                return $this->redirect('create');
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Characteristics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                if ($model->type != 0) {
                    if (($characteristics_data = Yii::$app->request->post('characteristics_data')) !== null && ($characteristics_data_sort = Yii::$app->request->post('characteristics_data_sort')) !== null) {
                        foreach ($characteristics_data as $key => $value) {
                            if (!$value) continue;
                            $characteristics_data_model = CharacteristicsData::findOne($key);
                            if (!$characteristics_data_model || $key == 'new') $characteristics_data_model = new CharacteristicsData();
                            $characteristics_data_model->name = $value;
                            $characteristics_data_model->parent_id = $id;
                            $characteristics_data_model->sort = ($characteristics_data_sort[$key] ? $characteristics_data_sort[$key] : 0);
                            $characteristics_data_model->save();
                        }


                    }
                } else {
                   // $characteristics_data_model = CharacteristicsData::deleteAll(['parent_id' => $model->id]);
                   // $characteristics_data_model = new CharacteristicsData();
                    //$characteristics_data_model->name = 'textinput';
                    //$characteristics_data_model->sort = 0;
                   // $characteristics_data_model->save();
                }
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Characteristics model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		return $this->redirect('/admin/characteristics');

        return $this->goback();
    }

    public function actionDeletechardata($id)
    {
        CharacteristicsData::findOne($id)->delete();
        return $this->redirect(Url::previous('char'));
    }


    /**
     * Finds the Characteristics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Characteristics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Characteristics::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
