<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\StaticText */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Статичные страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-text-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'text:ntext',
            'key',
            'name:ntext',
        ],
    ]) ?>

</div>
