<?php

namespace app\controllers;

use app\models\Articles;
use app\models\Articles2;
use app\models\CharacteristicsSort;
use app\models\Customform1;
use app\models\StaticText;
use app\models\Videos;
use yii\db\Query;

use app\models\Cats;
use app\models\CatsForProducts;
use app\models\Characteristics;
use app\models\CharacteristicsData;
use app\models\Functions;
use app\models\Products;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use app\models\CharacteristicsForProfuctTypes;

class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'PUT'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],

            ],
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        //получаем главные категории
        $cats = Cats::find()->where(['parent_id' => 0])->orderBy(['sort' => SORT_DESC])->all();
        return $this->render('index', [
            'main_cats' => $cats
        ]);
    }
    public function actionCatalog(){
        $this->layout = 'cats';
        $cats = Cats::find()->where(['parent_id' => 0])->orderBy(['sort' => SORT_DESC])->all();
        return $this->render('catalog',[
            'main_cats'=>$cats
        ]);
    }
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public  function actionCustomform1(){
        $model = new Customform1();
        if (Yii::$app->request->get('phone')){
            $model->phone = Yii::$app->request->get('phone');
        }
        if (Yii::$app->request->get('name')){
            $model->fio = Yii::$app->request->get('name');
        }
        if (Yii::$app->request->get('email')){
            $model->email = Yii::$app->request->get('email');
        }
        if (Yii::$app->request->get('year')){
            $model->year = Yii::$app->request->get('year');
        }
        if (Yii::$app->request->get('month')){
            $model->month = Yii::$app->request->get('month');
        }
        if (Yii::$app->request->get('day')){
            $model->day = Yii::$app->request->get('day');
        }
        if ($model->email){
            $mail = 'promo@maska-club.ru';
            $subject = 'Ваш бесплатный пригласительный в клуб «Maska» '.date('d-m-Y H:i:s');
            $message = '<p>Пригласительный дает право бесплатного входа в клуб для двух человек. Покажите это письмо при входе.</p>
            <p><img src="http://maska-club.ru/promo/invite.jpg" alt="Ваш пригласительный"></p>
            <p>Оформлен: '.date('d-m-Y H:i:s').'</p>';
            $message = '<html><body>'.$message.'</body></html>';
            $to  = $model->email;
            mail("$to",$subject,$message,"From: $mail\r\n"."Content-type: text/html; charset=utf-8\r\n"."X-Mailer: PHP mail script");

            $mail = 'promo@maska-club.ru';
            $subject = 'Оформлен новый пригласительный в клуб «Maska» '.date('d-m-Y H:i:s');
            $message = '';
            if (Yii::$app->request->get('phone')){
                $message.= '<p>Телефон: '.Yii::$app->request->get('phone').'</p>';
            }
            if (Yii::$app->request->get('name')){
                $message.= '<p>Фио: '.Yii::$app->request->get('name').'</p>';
            }
            if (Yii::$app->request->get('email')){
                $message.= '<p>Email: '.Yii::$app->request->get('email').'</p>';
            }
            if (Yii::$app->request->get('year')){
                $message.= '<p>Год: '.Yii::$app->request->get('year').'</p>';
            }
            if (Yii::$app->request->get('month')){
                $message.= '<p>Месяц: '.Yii::$app->request->get('month').'</p>';
            }
            if (Yii::$app->request->get('day')){
                $message.= '<p>День: '.Yii::$app->request->get('day').'</p>';
            }
            $to  = 'promo@maska-club.ru';
            mail("$to",$subject,$message,"From: $mail\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit");

        }
        echo '<pre>';
        print_r($model->save());
        echo '</pre>';die;
    }
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionCats($cat, $cat_id)
    {
        $this->layout = 'cats';
        $cat = Cats::findOne($cat_id);
        if (!$cat) throw new NotFoundHttpException('Категория не найдена!');
        //теперь проверяем есть ли подкатегории
        $childs = Cats::find()->where(['parent_id' => $cat->id])->orderBy('sort DESC')->all();
        if ($childs) {
            return $this->render('cats', [
                'cats' => $childs,
                'cat' => $cat,
            ]);
        } else {
            $functions = new Functions();
            //у нас есть категория $cat
            //получаем типы продуктов для категории
            $product_types = $functions->getProductTypes($cat->id);
            $filter = '';
            if ($product_types) {
                //теперь если есть прикрепленные типы продукта к категории, то вытаскиваем прикрепленные
                //характеристики
                $tmp = [];
                foreach ($product_types as $key => $value) {
                    $chars = CharacteristicsForProfuctTypes::find()
                        ->innerJoinWith('sort')
                        ->where(['characteristics_for_profuct_types.product_type_id' => $value['product_type_id']])
                        ->orderBy('characteristics_sort.sort DESC')
                        ->all();
                    foreach ($chars as $key2 => $value2) {
                        $tmp[$value2->characteristic_id] = $value2;
                    }
                }
                $view_flag = 'table';
                //теперь в массиве tmp содержатся все прикрепленные технические характеристики(это только начало)
                //теперь вызываем метод который выведет фильтр
                if (Yii::$app->request->post('characteristics')) {
                    $innerjoines = [];
                    $current_chars = Yii::$app->request->post('characteristics');
                    foreach ($current_chars as $key3 => $value3) {
                        $char = Characteristics::findOne($key3);
                        if ($char->type == 1) {
                            $innerjoines[1][$key3] = '  CFP1' . $key3 . '.character_data_id=' . $value3;
                        } elseif ($char->type == 3) {
                            $innerjoines[3][$key3] = '  CFP3' . $key3 . '.character_data_id=' . $value3;
                        } elseif ($char->type == 2) {
                            $checkox_tmp = [];

                            foreach ($value3 as $key4 => $value4) {
                                $checkox_tmp[] = 'CFP2' . $key3 . '.character_data_id=' . $value4;
                            }
                            if ($checkox_tmp) {
                                $checkox_tmp = ' (' . implode(' OR ', $checkox_tmp) . ')';
                                $innerjoines[2][$key3] = $checkox_tmp;
                            }

                        } elseif ($char->type == 0) {
                            if ($tmpp = explode(',', $value3)) {
                                $value3 = [];
                                if ($tmpp[0] == 0 && $tmpp[1] == 10000) continue;
                                $value3['min'] = $tmpp[0];
                                $value3['max'] = $tmpp[1];
                            }
                            $input_tmp = [];

                            if (isset($value3['min']) || isset($value3['max'])) {
                                if ($value3['min']) {
                                    $tmp_min = ' AND CAST(name AS UNSIGNED)>=' . $value3['min'];
                                }
                                if ($value3['max']) {
                                    $tmp_max = ' AND CAST(name AS UNSIGNED)<=' . $value3['max'];
                                }
                                $model = CharacteristicsData::find()
                                    ->where('parent_id=' . $key3 . $tmp_min . $tmp_max)
                                    ->all();
                                foreach ($model as $key5 => $value5) {
                                    $input_tmp[] = 'CFP0' . $key3 . '.character_data_id=' . $value5->id;
                                }
                                if ($input_tmp) {
                                    $input_tmp = ' (' . implode(' OR ', $input_tmp) . ')';
                                    $innerjoines[0][$key3] = $input_tmp;
                                } else {
                                    $innerjoines[0][$key3] = 'CFP0' . $key3 . '.character_data_id=-1';
                                }
                            }

                        }
                    }
                    $config['current_vals'] = Yii::$app->request->post('characteristics');
                    $filter = $functions->getcharacteristicsfilter($tmp, $config);
                } else {
                    $filter = $functions->getcharacteristicsfilter($tmp, []);
                }
                //иначе получаем продукты
                $products = CatsForProducts::find()
                    ->where(['cats_for_products.cat_id' => $cat->id])
                    ->joinWith('sort')
                    ->innerJoinWith('product')
                    ->orderBy('products_sort.sort DESC');
                if (isset($innerjoines[0])) {
                    foreach ($innerjoines[0] as $key10 => $value10) {
                        $products->innerJoin('characteristics_for_products AS CFP0' . $key10, 'CFP0' . $key10 . '.product_id=products.id AND ' . $value10);
                    }
                }
                if (isset($innerjoines[1])) {
                    foreach ($innerjoines[1] as $key10 => $value10) {
                        $products->innerJoin('characteristics_for_products AS CFP1' . $key10, 'CFP1' . $key10 . '.product_id=products.id AND ' . $value10);
                    }
                }
                if (isset($innerjoines[2])) {

                    foreach ($innerjoines[2] as $key10 => $value10) {
                        $products->innerJoin('characteristics_for_products AS CFP2' . $key10, 'CFP2' . $key10 . '.product_id=products.id AND ' . $value10);
                    }
                }
                if (isset($innerjoines[3])) {
                    foreach ($innerjoines[3] as $key10 => $value10) {
                        $products->innerJoin('characteristics_for_products AS CFP3' . $key10, 'CFP3' . $key10 . '.product_id=products.id AND ' . $value10);
                    }
                }
                $products->groupBy('products.id');


                $countQuery = clone $products;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
                $models = $products->offset($pages->offset)
                    ->limit($pages->limit)
                    ->orderBy('sort DESC,id DESC')
                    ->all();


            }
            return $this->render('products', [
                'products' => $models,
                'pages' => $pages,
                'cat' => $cat,
                'all_chars' => $tmp,
                'filter' => $filter
            ]);
        }
    }

    public function actionProduct($id)
    {
        $this->layout = 'product';
        $product = Products::findOne($id);
        if (!$product) throw new NotFoundHttpException('Товар не найден!');
        $pohozhie = CatsForProducts::find()
            ->select(['products.*', 'cats_for_products.product_id'])
            ->innerJoin('products', 'products.id=cats_for_products.product_id')
            ->where('cats_for_products.cat_id=' . $product->cat->cat_id)
            ->andWhere('products.active=1')
            ->andWhere('products.id<>' . $id)
            ->orderBy('RAND()')
            ->limit(4)
            ->all();
        $files = \app\models\FilesForProducts::find()->where('product_id='.$product->id.'')->asArray()->all();
        return $this->render('product', [
            'product' => $product,
            'pohozhie' => $pohozhie,
            'files' => $files,
        ]);
    }

    public function actionSearch($search)
    {
        $this->layout = 'search';

        $res = [];
        $query = new Query;
        $out = Cats::find()
            ->where('name LIKE "%' . $search . '%"')
            ->orderBy('name')
            ->all();
        //если найдена хоть одна категория то добавляем в массив
        if ($out) $res['cats'] = $out;
        $out = Products::find()
            ->where('products.name LIKE "%' . $search . '%"')
            ->orderBy('products.name')
            ->all();
        //если найден хоть один продукт то добавляем в массив
        if ($out) $res['products'] = $out;

        return $this->render('search', [
            'data' => $res,
            'search' => $search
        ]);
    }

    public function actionArticles()
    {
        $this->layout = 'cats';
        $articles = Articles::find()->orderBy('id DESC')->all();
        return $this->render('articles', [
            'articles' => $articles
        ]);
    }
    public function actionArticles2()
    {
        $this->layout = 'cats';
        $articles = Articles2::find()->orderBy('id DESC')->all();
        return $this->render('articles2', [
            'articles' => $articles
        ]);
    }


    public function actionInfo($url){
        $this->layout = 'cats';
        $text = StaticText::findOne(['key' => $url]);
        if (!$text) throw new NotFoundHttpException('страница не найдена');
        return $this->render('static_text', [
            'data' => $text
        ]);
    }

    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
    public function actionFoo(){
        $model = CharacteristicsForProfuctTypes::find()->all();
        foreach ($model as $key=>$value) {
            $model2 = CharacteristicsSort::findOne(['characteristic_id'=>$value->characteristic_id,'product_type_id'=>$value->product_type_id]);
            if ($model2) continue;
            $model2 = new CharacteristicsSort();
            $model2->characteristic_id = $value->characteristic_id;
            $model2->product_type_id = $value->product_type_id;
            $model2->sort = 0;
            $model2->save();
        }

    }
}
