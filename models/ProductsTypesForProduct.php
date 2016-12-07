<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_types_for_product".
 *
 * @property integer $id
 * @property integer $product_type_id
 * @property integer $product_id
 */
class ProductsTypesForProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_types_for_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_type_id', 'product_id'], 'required'],
            [['product_type_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_type_id' => 'Product Type ID',
            'product_id' => 'Product ID',
        ];
    }
}
