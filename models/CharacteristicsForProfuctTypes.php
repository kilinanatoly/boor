<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristics_for_profuct_types".
 *
 * @property integer $id
 * @property integer $characteristic_id
 * @property integer $product_type_id
 */
class CharacteristicsForProfuctTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'characteristics_for_profuct_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['characteristic_id', 'product_type_id'], 'required'],
            [['characteristic_id', 'product_type_id'], 'integer'],
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
        ];
    }
    public function getCharacteristics(){
        return $this->hasOne(Characteristics::className(),['id'=>'characteristic_id']);
    }
    public function getSort(){
        return $this->hasOne(CharacteristicsSort::className(),['characteristic_id'=>'characteristic_id']);
    }
}
