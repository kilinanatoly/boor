<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "images_for_products".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $url
 */
class ImagesForProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images_for_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'url'], 'required'],
            [['product_id','main_image'], 'integer'],
            [['url'], 'string', 'max' => 255],
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
            'url' => 'Url',
        ];
    }
}
