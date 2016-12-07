<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cats */
/* @var $form ActiveForm */
?>
<div class="site-cats_form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'data-pjax' => ''
        ]])
    ?>

        <?= $form->field($model, 'name') ?>

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
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-cats_form -->
