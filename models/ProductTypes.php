<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_types".
 *
 * @property integer $id
 * @property string $name
 */
class ProductTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'],  'unique', 'targetAttribute' => ['name'], 'message' => 'Данный тип продукта уже существует'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }
}
