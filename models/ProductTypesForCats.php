<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_types_for_cats".
 *
 * @property integer $id
 * @property integer $product_types_for_cats
 * @property integer $cat_id
 */
class ProductTypesForCats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_types_for_cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_type_id', 'cat_id'], 'required'],
            [['product_type_id', 'cat_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_type_id' => 'Product Types For Cats',
            'cat_id' => 'Cat ID',
        ];
    }

    public function getProducttype(){
        return $this->hasOne(ProductTypes::className(),['id'=>'product_type_id']);
    }



}
