<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "videos".
 *
 * @property integer $id
 * @property string $name
 * @property string $src
 * @property string $image
 * @property string $url
 */
class Videos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'videos';
    }

    /**
     * @inheritdoc
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['name', 'src'], 'required'],
            [['name', 'url'], 'string'],
            [['src', 'image'], 'string', 'max' => 255],
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
            'src' => 'iframe',
            'image' => 'Картинка',
            'url' => 'ссылка',
            'imageFile' => 'Картинка',
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            $filename = md5($this->imageFile->baseName.date('dd-mm-Y H:i:s')) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs('./images/videos/' . $filename);
            return $filename;
        } else {
            return false;
        }
    }
}
