<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (Yii::$app->request->get('cat_id')){
    $cat = \app\models\Cats::findOne(Yii::$app->request->get('cat_id'));
    $title = 'Все продукты категории '.$cat->name;
}else
{
    $title = 'Все продукты';
}
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить продукт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',
            [
                'attribute'=>'url',
                'format'=>'raw',
                'value'=>function($data){
                    $functions = new \app\models\Functions();
                    return '<a target="_blank" href="/products/'.$data->id.'">'.Yii::$app->request->hostInfo.'/products/'.$data->id.'</a>';
                }
            ],
            [
                'attribute'=>'spec',
                'filter'=>array("0"=>"Нет","1"=>"Да"),
                'value'=>function($result){
                    if ($result->spec == 0){
                        $v = 'Нет';
                    }else{
                        $v = 'Да';
                    }
                    return $v;
                },
            ],
            [
                'attribute'=>'active',
                'filter'=>array("0"=>"Нет","1"=>"Да"),
                'value'=>function($result){
                    if ($result->active == 0){
                        $v = 'Нет';
                    }else{
                        $v = 'Да';
                    }
                    return $v;
                },
            ],
            [
                'label'=>'Отсортировать',
                'format' => 'raw',
                'value'=>function($data){
                    if (!Yii::$app->request->get('cat_id')){
                        return false;
                    }
                    $sort = \app\models\ProductsSort::findOne(['cat_id'=>Yii::$app->request->get('cat_id'),'product_id'=>$data->id]);
                    if ($sort) $sort = $sort->sort;
                    else  $sort = 0;
                    $form = '
                    <form method="post" class="product_sort_form">
                        <input type="hidden" value="'.Yii::$app->request->get('cat_id').'" name="cat_id">
                        <input type="hidden" value="'.$data->id.'" name="product_id">
                        <input type="text" class="form-control" value="'.$sort.'" name="sort">
                        <button type="submit" class="btn btn-primary">Ок</button>
                        <p></p>
                    </form>
                    ';
                    return $form;
                }
            ],
            'price',
            // 'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
