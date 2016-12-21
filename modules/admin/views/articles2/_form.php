<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Articles */
/* @var $form yii\widgets\ActiveForm */
$session = Yii::$app->session;
echo $session->getFlash('add');
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ]])
    ?>
    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>

    <?php
    echo $form->field($model, 'text')->widget(CKEditor::className(), [
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]);
    ?>
    <?php
    if (!$model->isNewRecord){
        if ($model->image){
            echo '<p>Картинка:</p>';
            echo '<p><img class="img200" src="/images/articles2/' . $model->image . '" </p>';
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
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
