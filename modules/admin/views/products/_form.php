<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
        <li class="active"><a href="#main" data-toggle="tab">Общая информация</a></li>
        <li><a href="#cats" data-toggle="tab">Категории</a></li>
        <li><a href="#images" data-toggle="tab">Изображения</a></li>
        <li><a href="#characteristics" data-toggle="tab">Характеристики</a></li>
        <li><a href="#characteristics2" data-toggle="tab">Характеристики2</a></li>
        <li><a href="#komplekt" data-toggle="tab">Комплектация</a></li>
    </ul>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="main">
            <div class="form-group">
                <label>Тип продукта</label>
                <select name="product_types" class="form-control product_types" id="">
                    <?php
                    $product_type = NULL;
                    if ($model->isNewRecord){
                        echo '<option selected disabled>Выберите тип продукта</option>';
                    }else{
                        $product_type = \app\models\ProductsTypesForProduct::findOne(['product_id'=>$model->id]);
                    }
<<<<<<< HEAD
                    $product_types = \app\models\ProductTypes::find()->orderBy(['name'=>SORT_ASC])->all();
=======
                    $product_types = \app\models\ProductTypes::find()->orderBy(['id'=>SORT_ASC])->all();
>>>>>>> 18010ed7438c4c29cf2fdfe73138e044ae805330
                    foreach ($product_types as $key => $value) {
                        $checked='';
                        if ($product_type && $value['id']==$product_type->product_type_id){
                            $checked = ' selected ';
                        }
                        echo '<option '.$checked.' value="'.$value->id.'">'.$value->name.'</option>';
                    }
                    ?>
                </select>
            </div>
            <?= $form->field($model, 'name')->textInput() ?>
            <?= $form->field($model, 'short_description')->textInput() ?>
            <?= $form->field($model, 'metatitle') ?>
            <?= $form->field($model, 'metakeywords') ?>
            <?= $form->field($model, 'metadescription')->textarea() ?>
            <?= $form->field($model, 'price')->textInput() ?>
            <?= $form->field($model, 'spec')->checkbox() ?>
            <?= $form->field($model, 'active')->checkbox() ?>
           <?php
    echo $form->field($model, 'description')->widget(CKEditor::className(), [
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]);

           echo $form->field($model, 'description2')->widget(CKEditor::className(), [
               'editorOptions' => [
                   'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                   'inline' => false, //по умолчанию false
               ],
           ]);
           echo $form->field($model, 'description3')->widget(CKEditor::className(), [
               'editorOptions' => [
                   'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                   'inline' => false, //по умолчанию false
               ],
           ]);


    ?>
        </div>
        <div class="tab-pane" id="cats">
            <div class="cats">
                <?php
                    if ($model->isNewRecord){
                        echo '<p>Здесь пока что пусто</p>';
                    }else{
                        $cats_model = new \app\models\Cats();
                        $config['cats'] = \app\models\CatsForProducts::find()->where(['product_id'=>$model->id])->asArray()->all();
                        $config['product_type_id'] = $product_type->product_type_id;
                        $all_cats = $cats_model->view_cat_for_product($cats_model->get_cat(),0,$config);
                        echo $all_cats;
                    }
                ?>

            </div>
        </div>
        <div class="tab-pane" id="images">
            <?php
            if (!$model->isNewRecord){
                foreach ($images as $key => $value) {
                    echo '
                    <div class="images">
                        <p><img class="img-responsive" src="/images/products/'.$value['url'].'"> </p>
                        <p><label><input type="checkbox" name="deleteimage['.$value['id'].']">Удалить</label></p>
                        <p><label><input type="radio" name="mainimage" '.($value['main_image'] ? ' checked ': '').'value="'.$value['id'].'">Главная</label></p>
                    </div>
                    ';
                }

            }
            if (!$model->isNewRecord){
                if ($files){
                    echo '<hr>';
                    foreach ($files as $key => $value) {
                        echo '
                    <div class="images">
                        <p><label>'.$value['url'].'<input style="margin-left:10px;" type="checkbox" name="deletefile['.$value['id'].']">Удалить</label></p>
                    </div>
                    ';
                    }
                    echo '<hr>';
                }

            }

            ?>
           <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
           <?= $form->field($model, 'files[]')->fileInput(['multiple' => true]) ?>

        </div>
        <div class="tab-pane" id="characteristics">
            <?php
                if ($model->isNewRecord){
                    echo '<p>Пусто</p>';
                }else{
                    $functions = new \app\models\Functions();
                    $config['characteristics_for_product'] = \app\models\CharacteristicsForProducts::find()->where(['product_id'=>$model->id])->asArray()->all();
                    $config['product_id'] = $model->id;
                    $chars = $functions->getcharacteristics($product_type->product_type_id,$config);
                    echo $chars;
                }
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
