<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SharesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Атрибуты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shares-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить атрибут', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'ident',
            'max_val',
            [
                'attribute'=>'view_product',
                'filter'=>array("0"=>"Нет","1"=>"Да"),
                'value'=>function($result){
                    if ($result->view_product == 0){
                        $v = 'Нет';
                    }else{
                        $v = 'Да';
                    }
                    return $v;
                },
            ],
            [
                'attribute'=>'view_filter',
                'filter'=>array("0"=>"Нет","1"=>"Да"),
                'value'=>function($result){
                    if ($result->view_filter == 0){
                        $v = 'Нет';
                    }else{
                        $v = 'Да';
                    }
                    return $v;
                },
            ],
            [
                'attribute'=>'type',
                'filter'=>Yii::$app->params['characteristics'],
                'value'=>function($result){
                    return Yii::$app->params['characteristics'][$result->type];
                },
            ],


    [
    'class' => 'yii\grid\ActionColumn',
    'contentOptions' => ['style' => 'width:260px;'],
    'header'=>'Действия',
    'template' => '{update} {delete}',
    'buttons' => [
        //view button
        'view' => function ($url, $model) {
            return Html::a('<span class="fa fa-search"></span>View', $url, [
                'title' => Yii::t('app', 'View'),
                'class'=>'btn btn-primary btn-xs',
            ]);
        },
    ],

    ],
        ],
    ]); ?>

</div>
