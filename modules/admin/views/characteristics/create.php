<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Characteristics */

$this->title = 'Атрибуты';
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model->view_filter = 1;
$model->view_product = 1;
?>
<div class="characteristics-create">

    <h1><?= Html::encode($this->title) ?></h1>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs navtab1" role="tablist">
            <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Параметры</a></li>
            <li role="presentation" class="options" style="display:none;"><a href="#options" aria-controls="options" role="tab" data-toggle="tab">Опции</a></li>
        </ul>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
