<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Videos */

$this->title = 'Добавить видео';
$this->params['breadcrumbs'][] = ['label' => 'Видеоролики', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
