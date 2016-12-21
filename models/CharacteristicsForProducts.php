<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristics_for_products".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $character_data_id
 */
class   CharacteristicsForProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'characteristics_for_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'character_data_id'], 'required'],
            [['product_id', 'character_data_id'], 'integer'],
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
            'character_data_id' => 'Character Data ID',
        ];
    }
    public function getCharacterdata(){
        return $this->hasOne(CharacteristicsData::className(),['id'=>'character_data_id']);
    }
}
