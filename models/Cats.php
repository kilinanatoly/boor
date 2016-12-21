<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\bootstrap\Html;

/**
 * This is the model class for table "cats".
 *
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property integer $parent_id
 * @property integer $active
 * @property string $image
 * @property string $url
 * @property string $text_information
 * @property string $text
 */
class Cats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public $imageFile;
    public function rules()
    {
        return [
            [['name', 'sort', 'parent_id', 'active'], 'required'],
            [['name','text','url','description','metatitle','metakeywords','metadescription'], 'string'],
            [['sort', 'parent_id', 'active','text_information'], 'integer'],
            [['image','view_type'], 'string', 'max' => 255],
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
            'sort' => 'Сортировка',
            'parent_id' => 'ID родитял',
            'active' => 'Активность',
            'image' => 'Картинка',
            'imageFile' => 'Картинка',
            'text_information' => 'Использовать текстовую информацию в категории?',
            'text' => 'Текст категории',
            'view_type' => 'Визуализация категори',
            'metatitle' => 'Title',
            'metakeywords' => 'meta keywords',
            'metadescription' => 'meta description',
        ];
    }
    public $tree = '';

    public function get_cat($parent_id = 0)
    {
        $arr_cat = array();
        $result = Cats::find()->orderBy([ 'sort' => SORT_DESC, 'id' => SORT_DESC])->asArray()->all();
        if ($result) {
            //В цикле формируем массив
            for ($i = 0; $i < count($result); $i++) {
                $row = $result[$i];
                //Формируем массив, где ключами являются адишники на родительские категории
                if (empty($arr_cat[$row['parent_id']])) {
                    $arr_cat[$row['parent_id']] = array();
                }
                $arr_cat[$row['parent_id']][] = $row;
            }
            //возвращаем массив
            return $arr_cat;
        }
    }

    function view_cat($arr, $parent_id = 0)
    {

        //Условия выхода из рекурсии
        if (empty($arr[$parent_id])) {
            return $this->tree;
        }
        $this->tree .= '<ul '.($parent_id==key($arr) ? 'class="closed"' : 'class="closed"').'>';
        //перебираем в цикле массив и выводим на экран
        for ($i = 0; $i < count($arr[$parent_id]); $i++) {
            if (isset($arr[$arr[$parent_id][$i]['id']])>0) $var1 = '<a href="#" class="cats_down"><span class="pl glyphicon glyphicon-chevron-down" data-id="' . $arr[$parent_id][$i]['id'] . '"></span></a>';
            else $var1 = '-';
            $this->tree .= '<li>
                '.$var1.'
                <a class="pll" href="' . Url::to(['/admin/cats/index?parent_id=' . $arr[$parent_id][$i]['id']]) . '">'
                . $arr[$parent_id][$i]['name'] . '
                </a>' . ($arr[$parent_id][$i]['active'] == 1 ? '<span title="Категория активна" class="glyphicon glyphicon-ok" style="margin:0 4px;"></span>' : '<span title="Категория НЕ активна" style="margin:0 4px;" class="glyphicon glyphicon-remove"></span>') . '
                <a href="' . Url::to(['/admin/cats/update', 'cat_id' => $arr[$parent_id][$i]['id']]) . '"><span class="glyphicon glyphicon-pencil" title="Редактировать"></span></a>
                '.(!empty($arr[$arr[$parent_id][$i]['id']]) ? '<b style="margin-left:3px;">Удалить нельзя</b>' : '<a data-confirm="Вы действительно хотите удалить категорию?" data-method="post" title="Удалить" href="/admin/cats/delete?cat_id='.$arr[$parent_id][$i]['id'].'"><span class="glyphicon glyphicon-trash"></span></a>
                <a title="Перейти в товары категории" href="/admin/products/index?cat_id='.$arr[$parent_id][$i]['id'].'"><span class="glyphicon glyphicon-th"></span></a>');
            //рекурсия - проверяем нет ли дочерних категорий

            $this->view_cat($arr, $arr[$parent_id][$i]['id']);
            $this->tree .= '</li>';
        }

        $this->tree .= '</ul>';
        return $this->tree;
    }

    function view_cat_product_type($arr, $parent_id = 0,$config = [])
    {
        $tmp = [];
        if (isset($config['prouct_type_for_cats'])){
            foreach ($config['prouct_type_for_cats'] as $key => $value) {
                $tmp[] = $value['cat_id'];
            }
        }
        //Условия выхода из рекурсии
        if (empty($arr[$parent_id])) {
            return $this->tree;
        }
        $this->tree .= '<ul '.($parent_id==0 ? '' : 'class="closed"').'>';
        //перебираем в цикле массив и выводим на экран
        for ($i = 0; $i < count($arr[$parent_id]); $i++) {
            if (isset($arr[$arr[$parent_id][$i]['id']])>0) $var1 = '<a href="#" class="cats_down"><span class="pl glyphicon glyphicon-chevron-down" data-id="' . $arr[$parent_id][$i]['id'] . '"></span></a>';
            else $var1 = '-';
            $this->tree .= '<li>'.$var1.$arr[$parent_id][$i]['name'].
                '<input type="checkbox" class="admincheckbox"  '.(in_array($arr[$parent_id][$i]['id'],$tmp) ? ' checked ' : '').' value = "'.$arr[$parent_id][$i]['id'].'"name="cats[]" />';
            //рекурсия - проверяем нет ли дочерних категорий

            $this->view_cat_product_type($arr, $arr[$parent_id][$i]['id'],$config);
            $this->tree .= '</li>';
        }

        $this->tree .= '</ul>';
        return $this->tree;
    }

    function view_cat_for_product($arr, $parent_id = 0,$config = [])
    {

        $tmp1 = [];
        if (isset($config['cats'])){
            foreach ($config['cats'] as $key => $value) {
                $tmp1[] = $value['cat_id'];
            }

        }
        //Условия выхода из рекурсии
        if (empty($arr[$parent_id])) {
            return $this->tree;
        }
        $this->tree .= '<ul '.($parent_id==0 ? '' : 'class="closed"').'>';
        //перебираем в цикле массив и выводим на экран
        for ($i = 0; $i < count($arr[$parent_id]); $i++) {
            $checked = '';
            if (in_array($arr[$parent_id][$i]['id'],$tmp1)){
                $checked = ' checked ';
            }
            $flag = 0;
            if (empty($arr[$arr[$parent_id][$i]['id']])){
                $functions = new Functions();
                $tmp = $functions->check_product_type_for_cat($arr[$parent_id][$i]['id'],$config);
                if ($tmp) $flag = 1;
            }
            if (isset($arr[$arr[$parent_id][$i]['id']])>0) $var1 = '<a href="#" class="cats_down"><span class="pl glyphicon glyphicon-chevron-down" data-id="' . $arr[$parent_id][$i]['id'] . '"></span></a>';
            else $var1 = '-';
            $this->tree .= '<li>'.$var1.$arr[$parent_id][$i]['name'].
             ((empty($arr[$arr[$parent_id][$i]['id']]) && $flag) ? '<input type="checkbox" '.(!isset($config['cats']) ? ' checked ' : '').$checked.'class="admincheckbox"  value = "'.$arr[$parent_id][$i]['id'].'" name="cats[]" />' : '');
            //рекурсия - проверяем нет ли дочерних категорий

            $this->view_cat_for_product($arr, $arr[$parent_id][$i]['id'],$config);
            $this->tree.= '</li>';
        }
        $this->tree .= '</ul>';
        return $this->tree;
    }


    public function upload()
    {
        if ($this->validate()) {
            $filename = md5($this->imageFile->baseName.date('dd-mm-Y H:i:s')) . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs('./images/cats/' . $filename);
            return $filename;
        } else {
            return false;
        }
    }


    public function getProducttypes(){
        return $this->hasMany(ProductTypesForCats::className(),['cat_id'=>'id']);
    }
    public function getParent(){
        return $this->hasOne(Cats::className(),['id'=>'parent_id']);
    }
    public function getParents(){
        $parent = $this->parent;
        $parents[] = $parent->id;
        while ($parent->parent_id!=0){
            $parent = $parent->parent;
            $parents[] = $parent->id;
        }
        return $parents;
    }
    public function getChilds(){
        return $this->hasMany(Cats::className(),['parent_id'=>'id'])->orderBy('sort DESC,id DESC');
    }

}
