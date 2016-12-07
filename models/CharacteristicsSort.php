<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristics_sort".
 *
 * @property integer $id
 * @property integer $characteristic_id
 * @property integer $product_type_id
 * @property integer $sort
 */
class CharacteristicsSort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'characteristics_sort';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['characteristic_id', 'product_type_id', 'sort'], 'required'],
            [['characteristic_id', 'product_type_id', 'sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'characteristic_id' => 'Characteristic ID',
            'product_type_id' => 'Product Type ID',
            'sort' => 'Sort',
        ];
    }
    public function getCharacteristics(){
        return $this->hasOne(Characteristics::className(),['id'=>'characteristic_id']);
    }
    public function getProducttypesforhars(){
        return $this->hasOne(CharacteristicsForProfuctTypes::className(),['characteristic_id'=>'characteristic_id','product_type_id'=>'product_type_id']);
    }

}
