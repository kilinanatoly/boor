<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "static_text".
 *
 * @property integer $id
 * @property string $text
 * @property string $key
 * @property string $name
 */
class StaticText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'static_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'key', 'name'], 'required'],
            [['text', 'name'], 'string'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Содержимое',
            'key' => 'Ключ',
            'name' => 'Название',
        ];
    }
}
