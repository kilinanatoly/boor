<?php

namespace app\controllers;

use app\models\Cats;
use app\models\CharacteristicsData;
use app\models\CharacteristicsForProfuctTypes;
use app\models\Emails;
use app\models\Functions;
use app\models\Products;
use app\models\ProductsSort;
use Yii;
use app\models\Characteristics;
use app\models\CharacteristicsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\Json;

/**
 * CharacteristicsController implements the CRUD actions for Characteristics model.
 */
class AjaxController extends Controller
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

    public function actionGetcharacteristics(){
        if (Yii::$app->request->post('product_type_id')){
            $functions = new Functions();
                 echo $functions->getcharacteristics(Yii::$app->request->post('product_type_id'),[]);
            }
    }

    public function actionGetcats(){
        if (!Yii::$app->request->post('product_type_id')) return 'fail';
        $model = new Cats();
        $config['product_type_id'] = Yii::$app->request->post('product_type_id');
        $cats = $model->view_cat_for_product($model->get_cat(),0,$config);
        return $cats;
    }

    /**
     * Lists all Characteristics models.
     * @return mixed
     */

    public function actionSendform(){
        $title = Yii::$app->request->post('title');
        $url = Yii::$app->request->post('product');
        $name = Yii::$app->request->post('name') ? Yii::$app->request->post('name') : 'Пусто';
        $tel =  Yii::$app->request->post('tel') ? Yii::$app->request->post('tel') :  'Пусто';
        $text = Yii::$app->request->post('text') ? Yii::$app->request->post('text') :  'Пусто';
		$email = Yii::$app->request->post('email') ? Yii::$app->request->post('email') :  'Пусто';
        $emails = Emails::find()->all();
        $functions = new Functions();

        foreach ($emails as $key => $value) {
            $config = [
                'title'=>$title,
                'subject'=>$title,
                'to'=>$value->email,
                'text'=>'
                    <p>'.$title.'</p>
                    <p>Имя:'.$name.'</p>
                    <p>Телефон :'.$tel.'</p>
                    <p>Email : '.$email.'</p>
					<p>Комментарий:'.$text.'</p>
					<p>Ссылка:<a href="'.Yii::$app->request->hostInfo.$url.'"></a>'.Yii::$app->request->hostInfo.$url.'</p>
                ',
            ];
            $functions->sendemail2($config);
        }
        return 'success';
    }
	
	
	
	
	
	
    public function actionObrat(){
        $name = Yii::$app->request->post('name') ? Yii::$app->request->post('name') : 'Пусто';
        $tel =  Yii::$app->request->post('tel') ? Yii::$app->request->post('tel') :  'Пусто';

        $emails = Emails::find()->all();
        $functions = new Functions();

        foreach ($emails as $key => $value) {
            $config = [
                'title'=>'Обратный звонок',
                'subject'=>'Обратный звонок',
                'to'=>$value->email,
                'text'=>'
                    <p>Обратный звонок</p>
                    <p>Имя:'.$name.'</p>
                    <p>Телефон или email:'.$tel.'</p>
                ',
            ];
            $functions->sendemail2($config);
        }
        return 'success';
    }

    public function actionZayavka(){
        $name = Yii::$app->request->post('name') ? Yii::$app->request->post('name') : 'Пусто';
        $tel =  Yii::$app->request->post('tel') ? Yii::$app->request->post('tel') :  'Пусто';
        $text = Yii::$app->request->post('text') ? Yii::$app->request->post('text') :  'Пусто';
        $emails = Emails::find()->all();
        $functions = new Functions();

        foreach ($emails as $key => $value) {
            $config = [
                'title'=>'Новая заявка',
                'subject'=>'Новая заявка',
                'to'=>$value->email,
                'text'=>'
                    <p>Новая заявка</p>
                    <p>Имя:'.$name.'</p>
                    <p>Телефон или email:'.$tel.'</p>
                    <p>Текст:'.$text.'</p>
                ',
            ];
            $functions->sendemail2($config);
        }
        return 'success';
    }

    public function actionQuestions(){
        $name = Yii::$app->request->post('name') ? Yii::$app->request->post('name') : 'Пусто';
        $tel =  Yii::$app->request->post('tel') ? Yii::$app->request->post('tel') :  'Пусто';
        $text = Yii::$app->request->post('text') ? Yii::$app->request->post('text') :  'Пусто';
        $emails = Emails::find()->all();
        $functions = new Functions();

        foreach ($emails as $key => $value) {
            $config = [
                'title'=>'Запрос на спец цену оборудования',
                'subject'=>'Запрос на спец цену оборудования',
                'to'=>$value->email,
                'text'=>'
                    <p>Запрос на спец цену оборудования</p>
                    <p>Имя:'.$name.'</p>
                    <p>Телефон или email:'.$tel.'</p>
                    <p>Текст:'.$text.'</p>
                ',
            ];
            $functions->sendemail2($config);
        }
        return 'success';
    }
    public function actionSpec(){
        $functions = new Functions();
        $product_id = Yii::$app->request->post('product_id');
        $product = Products::findOne($product_id);
        $title = $product->name;
        $url = $functions->getproducturl($product->id);
        $name = Yii::$app->request->post('name') ? Yii::$app->request->post('name') : 'Пусто';
        $tel =  Yii::$app->request->post('tel') ? Yii::$app->request->post('tel') :  'Пусто';
        $text = Yii::$app->request->post('text') ? Yii::$app->request->post('text') :  'Пусто';
        $emails = Emails::find()->all();
        $functions = new Functions();

        foreach ($emails as $key => $value) {
            $config = [
                'title'=>'Заявка на продукт по спецпредложению :'.$title,
                'subject'=>'Заявка на продукт по спецпредложению :'.$title,
                'to'=>$value->email,
                'text'=>'
                    <p>Заявка на продукт по спецпредложению :'.$title.'</p>
                    <p>Ссылка:<a href="'.Yii::$app->request->hostInfo.$url.'"></a>'.Yii::$app->request->hostInfo.$url.'</p>
                    <p>Имя:'.$name.'</p>
                    <p>Телефон или email:'.$tel.'</p>
                    <p>Текст:'.$text.'</p>
                ',
            ];
            $functions->sendemail2($config);
        }
        return 'success';
    }

    public function actionProductsList($q = null) {
        $query = new Query;
        $query->select('name')
            ->from('products')
            ->where('name LIKE "%' . $q .'%" AND active=1')
            ->orderBy('name');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['name'],'query' => $q];
        }
        echo Json::encode($out);
    }

    public function actionCatsList($q = null) {
        $query = new Query;
        $query->select('name')
            ->from('cats')
            ->where('name LIKE "%' . $q .'%"')
            ->orderBy('name');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['name'],'query' => $q];
        }
        echo Json::encode($out);
    }

    public function actionProductsort(){
        if (Yii::$app->request->post()){
            $sort = Yii::$app->request->post('sort');
            $cat_id = Yii::$app->request->post('cat_id');
            $product_id = Yii::$app->request->post('product_id');
            $model = ProductsSort::findOne(['cat_id'=>$cat_id,'product_id'=>$product_id]);
            if (!$model){
                $model = new ProductsSort();
            }
            $model->sort = $sort;
            $model->cat_id = $cat_id;
            $model->product_id = $product_id;
            if ($model->save()) return 'success';
        }
    }
}
