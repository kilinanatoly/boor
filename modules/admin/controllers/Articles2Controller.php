<?php

namespace app\modules\admin\controllers;

use app\models\Articles2;
use app\models\Articles2Search;
use app\models\Functions;
use Yii;
use app\models\Articles;
use app\models\ArticlesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticlesController implements the CRUD actions for Articles model.
 */
class Articles2Controller extends Controller
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
     * Lists all Articles models.
     * @return mixed
     */
    public $layout = 'admin';
    public function actionIndex()
    {
        $searchModel = new Articles2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Articles model.
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
     * Creates a new Articles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Articles2();
        $functions = new Functions();
        if ($model->load(Yii::$app->request->post())) {
            $model->url = $functions->str2url($model->name);
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile) {
                if ($model->upload()) {
                    $filename = $model->upload();
                    $model->setAttribute('image', $filename);
                }
            }
            if ($model->validate()) {
                if ($model->save()) {
                    $session = Yii::$app->session;
                    $session->setFlash('add', '<div class="alert alert-success">Вы успешно добавили статью.</div>');
                    $model = new Articles2();
                }
                // form inputs are valid, do something here
            }
        }
            return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Articles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $functions = new Functions();
        if ($model->load(Yii::$app->request->post())) {
            $model->url = $functions->str2url($model->name);
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile) {
                if ($model->upload()) {
                    $filename = $model->upload();
                    $model->setAttribute('image', $filename);
                }
            }
            if ($model->validate()) {
                if ($model->save()) {
                    $session = Yii::$app->session;
                    $session->setFlash('add', '<div class="alert alert-success">Сохранено.</div>');
                }
                // form inputs are valid, do something here
            }
        }
            return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing Articles model.
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
     * Finds the Articles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Articles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Articles2::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
