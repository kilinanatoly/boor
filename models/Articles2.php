<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $image
 * @property string $url
 */
class Articles2 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles2';
    }

    /**
     * @inheritdoc
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['name', 'text', 'url','reg_date'], 'string'],
            [['image'], 'string', 'max' => 255],
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
            'text' => 'Текст',
            'image' => 'Картинка',
            'url' => 'Url',
            'imageFile' => 'Картинка',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $filename = md5($this->imageFile->baseName.date('dd-mm-Y H:i:s')) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs('./images/articles2/' . $filename);
            return $filename;
        } else {
            return false;
        }
    }
}
