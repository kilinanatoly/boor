<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VideosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Видеоролики';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить видеоролик', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name:ntext',
            'src',
            [
                'attribute'=>'image',
                'format'=>'raw',
                'value'=>function($data){
                    if (!$data->image){
                        return '<img class=" admin_image" src="/images/site_images/no_image.png">';
                    }
                    return '<img class="admin_image" src="/images/articles/'.$data->image.'">';
                }
            ],
            [
                'attribute'=>'url',
                'format'=>'raw',
                'value'=>function($data){
                    return '<a href="'.Yii::$app->request->hostInfo.'/videos/'.$data->url.'">'.Yii::$app->request->hostInfo.'/videos/'.$data->url.'</a>';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
