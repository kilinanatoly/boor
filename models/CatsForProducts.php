<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cats_for_products".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property integer $product_id
 */
class CatsForProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats_for_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'product_id'], 'required'],
            [['cat_id', 'product_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'product_id' => 'Product ID',
        ];
    }
    public function getProduct(){
        return $this->hasOne(Products::className(),['id'=>'product_id']);
    }
    public function getCat(){
        return $this->hasOne(Cats::className(),['id'=>'cat_id']);
    }
    public function getSort(){
        return $this->hasOne(ProductsSort::className(),['product_id'=>'product_id','cat_id'=>'cat_id']);
    }
}
