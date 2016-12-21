<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StaticText */

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Статичные страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
