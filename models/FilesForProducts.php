<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "files_for_products".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $url
 */
class FilesForProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files_for_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'url'], 'required'],
            [['product_id'], 'integer'],
            [['url'], 'string'],
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
