<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Емаилы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emails-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>На данные емаилы будут отправлять все уведомления в обратных звонках, запросах и т.д.</p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить емаил', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
