<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
Url::remember(['/admin/characteristics/update?id='.$model->id.''],'char');

/* @var $this yii\web\View */
/* @var $model app\models\Characteristics */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="characteristics-form">
    <?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ]
    ]); ?>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="main">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'type')->dropDownList(Yii::$app->params['characteristics'], ['class' => 'type form-control']
            ); ?>
            <?php
                echo $form->field($model, 'ident')->textInput();
                echo $form->field($model, 'max_val')->textInput();
            ?>
            <?= $form->field($model, 'view_filter')->checkbox() ?>
            <?= $form->field($model, 'view_product')->checkbox() ?>
            <?php
            if (!$model->isNewRecord) {
                echo $form->field($model, 'sort')->textInput();
            }
            ?>
        </div>

        <div role="tabpanel" class="tab-pane" id="options">
            <div class="inputs">
                <div class="form-group">
                    <?php
                    if ($model->isNewRecord) {
                        echo '
                            <p>
                                <label>
                                    <input type="text" class="form-control" name="characteristics_data[]" placeholder="Опция">
                                </label>
                                <label>
                                    <input type="text" class="form-control" name="characteristics_data_sort[]" placeholder="Сортировка">
                                </label>
                            </p>
                        ';
                    } else {
                        foreach ($model->characteristicsData as $key => $value) {
                            echo '
                                <p>
                                    <label>
                                        <input type="text" class="form-control" value="' . $value->name . '" name="characteristics_data['.$value->id.']" placeholder="Опция">
                                    </label>
                                    <label>
                                        <input type="text" class="form-control" value="' . $value->sort . '" name="characteristics_data_sort['.$value->id.']" placeholder="Сортировка">
                                    </label>
                                    <a data-confirm="Вы действительно хотите удалить категорию?" data-method="post" href="/admin/characteristics/deletechardata?id='.$value->id.'">Удалить</a>
                                </p>
                            ';

                        }
                        echo '
                        <p>
                            <label>
                                <input type="text" class="form-control" name="characteristics_data[new]" placeholder="Опция">
                            </label>
                            <label>
                                <input type="text" class="form-control" name="characteristics_data_sort[new]" placeholder="Сортировка">
                            </label>
                        </p>
                        ';
                    }
                    ?>

                </div>
            </div>
            <p><a href="#" class="add_char_data">Добавить еще...</a></p>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
