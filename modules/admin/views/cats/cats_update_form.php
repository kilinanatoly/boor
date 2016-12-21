<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Cats */
/* @var $form ActiveForm */
?>
<div class="site-cats_update_form">

       <?php $form = ActiveForm::begin([
           'id'=>'form1',
        'options' => [
            'enctype' => 'multipart/form-data',
            'data-pjax' => ''
        ]])
    ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'description')->textarea() ?>
    <?= $form->field($model, 'metatitle') ?>
    <?= $form->field($model, 'metakeywords') ?>
    <?= $form->field($model, 'metadescription')->textarea() ?>
    <?php
    if ($model->image) {
        echo '<p>Картинка:</p>';
        echo '<p><img class="img200" src="/images/cats/' . $model->image . '" </p>';
    }
    ?>
    <?= $form->field($model, 'imageFile')->widget(\dosamigos\fileinput\BootstrapFileInput::className(), [
        'options' => ['accept' => 'image/*', 'multiple' => false],
        'clientOptions' => [
            'previewFileType' => 'text',
            'browseClass' => 'btn btn-success',
            'removeClass' => 'btn btn-danger',
            'removeIcon' => '<i class="glyphicon glyphicon-trash"></i> '
        ]
    ]); ?>
    <?= $form->field($model, 'sort') ?>
    <?= $form->field($model, 'view_type')->dropDownList(['table'=>'Таблица','blocks'=>'Блоки']) ?>
    <?= $form->field($model, 'active')->checkbox() ?>
    <?= $form->field($model, 'text_information')->checkbox() ?>
    <?php
    if ($model->text_information==1){
        echo $form->field($model, 'text')->widget(CKEditor::className(), [
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]);
    }
     ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-cats_form -->
