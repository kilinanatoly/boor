<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-types-form">

    <?php $form = ActiveForm::begin(); ?>
    <ul class="nav nav-tabs navtab2" role="tablist">
        <li role="presentation" class="active"><a href="#options" aria-controls="options" role="tab" data-toggle="tab">Опции</a></li>
        <li role="presentation" class="options"><a href="#cats" aria-controls="cats" role="tab" data-toggle="tab">Прикрепить к категориям</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="options">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <div class="left">
                <p><b>Аттрибуты типа продукта</b></p>
                <select name="attributes[]" id="attributes" multiple="multiple" style="overflow-y: scroll ">
                    <?php
                    $tmp = [];
                        //если редактирование то делаем выборку прикрепленных атрибутов
                        if (!$model->isNewRecord){
                            $characteristics = \app\models\CharacteristicsForProfuctTypes::find()->where(['product_type_id'=>$model->id])->all();
                            foreach ($characteristics as $key => $value) {
                                echo '<option value="'.$value['characteristic_id'].'" >'.$value->characteristics->name.'('.$value->characteristics->ident.')'.'</option>';
                                $tmp[] = $value['characteristic_id'];
                            }

                        }
                    ?>
                </select>
            </div>
            <div class="right">
                <p><b>Доступные аттрибуты</b></p>
                <select name="attributes1[]" id="attributesList" multiple="multiple" style="overflow-y: scroll ">
                    <?php
                    //делаем выборку аттрибутов
                    $characteristics = \app\models\Characteristics::find()->orderBy(['name'=>SORT_DESC])->asArray()->all();
                    foreach ($characteristics as $key => $value) {
                        if (!in_array($value['id'],$tmp)){
                            echo '<option value="'.$value['id'].'" data-id="'.$value['id'].'">'.$value['name'].'('.$value['ident'].')'.'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="sort">
                <?php
                if (!$model->isNewRecord){
                    echo '<h3>Сортировка аттрибутов:</h3>';
                    $characteristics = \app\models\CharacteristicsSort::find()
                        ->innerJoinWith('producttypesforhars')
                        ->where(['characteristics_sort.product_type_id'=>$model->id])
                        ->orderBy(['characteristics_sort.sort'=>SORT_DESC])
                        ->all();
                    foreach ($characteristics as $key => $value) {
                        echo '<p>'.$value->characteristics->name.'<input type="text" name="sort['.$value->characteristic_id.']" class="form-control" value="'.$value->sort.'"/></p>';
                    }

                }
                ?>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane" id="cats">
            <?php
            $config = [];
            $cats = new \app\models\Cats();
            if (!$model->isNewRecord){
                $product_type_for_cats = \app\models\ProductTypesForCats::find()->where(['product_type_id'=>$model->id])->asArray()->all();
                $config['prouct_type_for_cats'] = $product_type_for_cats;
            }
            echo $cats->view_cat_product_type($cats->get_cat(),0,$config);
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
