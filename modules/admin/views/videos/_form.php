<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Videos */
/* @var $form yii\widgets\ActiveForm */
$session = Yii::$app->session;
echo $session->getFlash('add');
?>

<div class="videos-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ]])
    ?>
    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'src')->textInput(['maxlength' => true]) ?>
    <?php
    if (!$model->isNewRecord){
        if ($model->image){
            echo '<p>Картинка:</p>';
            echo '<p><img class="img200" src="/images/articles/' . $model->image . '" </p>';
        }
    }
    ?>
    <?=  $form->field($model, 'imageFile')->widget(\dosamigos\fileinput\BootstrapFileInput::className(), [
        'options' => ['accept' => 'image/*', 'multiple' => false],
        'clientOptions' => [
            'previewFileType' => 'text',
            'browseClass' => 'btn btn-success',
            'removeClass' => 'btn btn-danger',
            'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> '
        ]
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Редактировать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
