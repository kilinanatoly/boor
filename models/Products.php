<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property double $price
 * @property integer $spec
 * @property integer $active
 * @property string $description
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public  $imageFiles;
    public  $files;
    public function rules()
    {
        return [
            [['name', 'url', 'price', 'spec', 'active', 'description','description2','description3'], 'string'],
            [['name', 'description','description2','description3','metatitle','metakeywords','metadescription','short_description'], 'string'],
            [['price'], 'number'],
            [['spec', 'active'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 5,'checkExtensionByMimeType' => false],
            [['files'], 'file', 'skipOnEmpty' => true, 'maxFiles' => 5,'checkExtensionByMimeType' => false],

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
            'url' => 'Url',
            'price' => 'Цена',
            'spec' => 'Спецпредложение?',
            'files' => 'Файлы',
            'active' => 'Активность',
            'description' => 'Описание',
            'imageFiles' => 'Картинки',
            'description2' => 'Технические характеристики',
            'description3' => 'Комплектация',
            'metatitle' => 'Title',
            'metakeywords' => 'meta keywords',
            'metadescription' => 'meta description',
            'short_description' => 'Короткое описание (выводится в списке продуктов)',
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $ran = rand(1000,1000000);
                $filename[] = md5($file->baseName.date('Y-m-d-h-i-s').$ran).'.'.$file->extension;
                $filename1 =md5($file->baseName.date('Y-m-d-h-i-s').$ran).'.'.$file->extension;
                $file->saveAs('./images/products/' . $filename1);
            }
            return $filename;
        } else {
            return false;
        }
    }
    public function upload_files($product_id)
    {
        if (!file_exists('./files/' . $product_id)){
            mkdir("./files/$product_id", 0700);
        }
        if ($this->validate()) {
            foreach ($this->files as $file) {
                $filename1 =$file->baseName.'.'.$file->extension;
                $filename[] = $filename1;
                $file->saveAs('./files/'.$product_id.'/' . $filename1);
            }
            return $filename;
        } else {
            return false;
        }
    }
    public function getImage(){
        return $this->hasOne(ImagesForProducts::className(),['product_id'=>'id'])->orderBy('main_image DESC,id ASC');
    }
    public function getImages(){
        return $this->hasMany(ImagesForProducts::className(),['product_id'=>'id'])->orderBy('main_image DESC,id ASC');
    }
    public function getCharacteristics(){
        return $this->hasMany(CharacteristicsForProducts::className(),['product_id'=>'id']);
    }
    public function getCat(){
        return $this->hasOne(CatsForProducts::className(),['product_id'=>'id']);
    }
    public function getCats(){
       $parent = $this->cat->cat;
        if (!$parent) return false;
        $parents[] = $parent->id;
        $parents2 = $parent->parents;
        if ($parents2){
            $parents = array_merge($parents,$parents2);
        }
        return $parents;
    }
    public function getSort(){
        return $this->hasMany(ProductsSort::className(),['product_id'=>'id']);
    }
}
