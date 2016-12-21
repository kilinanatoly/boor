<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Emails */

$this->title = 'Добавить email';
$this->params['breadcrumbs'][] = ['label' => 'Еmail-ы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="emails-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
