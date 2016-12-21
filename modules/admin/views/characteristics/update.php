<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Characteristics */

$this->title = 'Редактирование атрибута: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="characteristics-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="nav nav-tabs navtab1" role="tablist">
        <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Параметры</a></li>
        <li role="presentation" class="options" style="<?=($model->type==0) ? 'display:none;' : ''?>"><a href="#options" aria-controls="options" role="tab" data-toggle="tab">Опции</a></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
