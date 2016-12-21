<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristics_data".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $sort
 */
class CharacteristicsData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'characteristics_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['parent_id', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
            'sort' => 'Sort',
        ];
    }
    public function getCharacteristic(){
        return $this->hasOne(Characteristics::className(),['id'=>'parent_id']);
    }
}
