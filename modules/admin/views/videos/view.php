<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Videos */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Видеоролики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот видеоролик?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'src',
            [
                'label'=>'Картинка',
                'format'=>'raw',
                'value'=>($model->image ? '<img class="admin_image" src="/images/articles/'.$model->image.'">' : '<img class="admin_image" src="/images/site_images/no_image.png">')
            ],
            'url',
        ],
    ]) ?>

</div>
