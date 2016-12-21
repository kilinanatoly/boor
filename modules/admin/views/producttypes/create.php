<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ProductTypes */

$this->title = 'Добавление типа продуктов';
$this->params['breadcrumbs'][] = ['label' => 'Типа продуктов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-types-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
