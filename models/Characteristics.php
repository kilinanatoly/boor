<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristics".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $view_product
 * @property integer $view_filter
 * @property integer $sort
 */
class Characteristics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'characteristics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type', 'view_product', 'view_filter', 'sort', 'ident'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['max_val'], 'integer'],
            ['ident', 'unique', 'targetClass' => Characteristics::className(), 'message' => 'Уже занято'],
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
            'type' => 'Тип',
            'view_product' => 'Показать в продукте',
            'view_filter' => 'Показать в фильтре',
            'sort' => 'Сортировка',
            'ident' => 'Идентификатор',
            'max_val' => 'Максимальное значение(целое число)',
        ];
    }

    public function getCharacteristicsData()
    {
        return $this->hasMany(CharacteristicsData::className(), ['parent_id' => 'id'])->orderBy('sort DESC,id DESC');
    }
}
