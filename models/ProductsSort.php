<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_sort".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $cat_id
 * @property integer $sort
 */
class ProductsSort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_sort';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'cat_id', 'sort'], 'required'],
            [['product_id', 'cat_id', 'sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'cat_id' => 'Cat ID',
            'sort' => 'Sort',
        ];
    }
}
