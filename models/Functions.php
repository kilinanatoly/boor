<?php


namespace app\models;


use Yii;

use yii\base\Model;
use yii\web\NotFoundHttpException;


/**
 * LoginForm is the model behind the login form.
 */
class Functions extends Model

{


    public function ad_name($value)

    {


        return strtolower($this->translit(trim($value['name']))) . '-' . $value['id'];

    }


    public function translit($str)
    {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', ' ', '/', ',', '"', '_');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'ZH', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', '', 'Y', 'E', 'E', 'Ju', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', '', 'y', '', 'e', 'ju', 'ya', '-', '-', '', '', '');
        return str_replace($rus, $lat, $str);
    }

    public function str2url($str)
    {
        // переводим в транслит
        $str = $this->translit($str);
        // в нижний регистр
        $str = strtolower($str);
        // заменям все ненужное нам на "-"
        //~[^-a-z0-9_]+~u (было)
        $str = preg_replace('~[^-a-z0-9_]+~i', '-', $str);
        $str = preg_replace('~([-])\1+~i', '\\1', $str);
        // удаляем начальные и конечные '-'
        $str = trim($str, "-");
        //удаляем начинания цифр
        return $str;
    }

    function get_ad_date($date)
    {

        $date = explode('.', $date);
        switch ($date[1]) {
            case '01':
                $month = 'января';
                break;
            case '02':
                $month = 'февраля';
                break;
            case '03':
                $month = 'марта';
                break;
            case '04':
                $month = 'апреля';
                break;
            case '05':
                $month = 'мая';
                break;
            case '06':
                $month = 'июня';
                break;
            case '07':
                $month = 'июля';
                break;
            case '08':
                $month = 'августа';
                break;
            case '09':
                $month = 'сентября';
                break;
            case '10':
                $month = 'октября';
                break;
            case '11':
                $month = 'ноября';
                break;
            case '12':
                $month = 'декабря';
                break;
        }

        return $date = $date[0] . ' ' . $month . ' ' . $date[2];

    }

    function SendMail($from, $to, $subject, $message)
    {
        $headers = "From: admin@zielonka-shop.ru <" . $from . ">\n";
        $headers .= "Content-Type: text/html; charset=utf-8";
        $result = mail($to, $subject, $message, $headers);
        return $result;

    }


    function tel_mask($tel)

    {
        $tel = str_replace(['+7', ' ', '(', ')', '-'], '', $tel);
        return $tel;

    }

    function getBread($cat_id)
    {
        $cat = Cats::findOne($cat_id);
        if ($cat_id == 0) return $mas = [];
        if (!$cat) return false;
        $mas[] = [
            'id' => $cat->id,
            'name' => $cat->name,
            'url' => $cat->url
        ];
        if ($cat->parent_id != 0) {
            while ($cat->parent_id != 0) {
                $cat = Cats::findOne($cat->parent_id);
                if (!$cat) continue;
                $mas[] = [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'url' => $cat->url
                ];
            }
        }
        return array_reverse($mas);
    }

    function get_url($cat_id)
    {
        $cat = Cats::findOne($cat_id);
        if ($cat_id == 0) return $mas = [];
        if (!$cat) return false;
        $mas[] = $cat->url;
        if ($cat->parent_id != 0) {
            while ($cat->parent_id != 0) {
                $cat = Cats::findOne($cat->parent_id);
                if (!$cat) continue;
                $mas[] = $cat->url;
            }
        }

        if (count($mas) < 2) {
            return '/catalog/' . $mas[0] . '_' . $cat->id;
        } else {
            return '/catalog/' . implode('/', array_reverse($mas)) . '_' . $cat_id;
        }
    }

    function check_product_type_for_cat($cat_id, $config = [])
    {
        $model = ProductTypesForCats::findOne(['cat_id' => $cat_id, 'product_type_id' => $config['product_type_id']]);
        if ($model) return true;
        $cat = Cats::findOne($cat_id);
        if ($cat->parent_id == 0) return false;
        while ($cat = Cats::findOne(['id' => $cat->parent_id])) {
            $model = ProductTypesForCats::findOne(['cat_id' => $cat->id, 'product_type_id' => $config['product_type_id']]);
            if ($model) return true;
        }
        return false;
    }

    function getcharacteristics($product_type_id, $config = [])
    {
        if (isset($config['characteristics_for_product'])) {
            foreach ($config['characteristics_for_product'] as $key => $value) {
                $mas[$value['character_data_id']] = $value['character_data_id'];
            }
        }
        $chars = CharacteristicsForProfuctTypes::find()->where(['product_type_id' => $product_type_id])->all();
        $tmp = '';
        foreach ($chars as $key => $value) {
            $type = $value->characteristics->type;
            $charact_name = $value->characteristics->name;
            if ($type == 0) {
                $val = '';
                if (isset($config['characteristics_for_product'])) {
                    $model = CharacteristicsForProducts::find()
                        ->select(['characteristics_for_products.*', 'characteristics_data.name'])
                        ->where(['characteristics_for_products.product_id' => $config['product_id']])
                        ->innerJoin('characteristics_data', 'characteristics_data.id=characteristics_for_products.character_data_id AND characteristics_data.parent_id=' . $value->characteristics->id)
                        ->asArray()
                        ->one();
                    $val = $model['name'];
                }

                $tmp .= '
                <p>' . $charact_name . '</p>
                <p><input class="form-control" value="' . $val . '" name="characteristics[' . $value->characteristics->id . ']"/></p>
                ';
            } elseif ($type == 1) {
                $tmp .= '
                <p>' . $charact_name . '</p>';
                foreach ($value->characteristics->characteristicsData as $key2 => $value2) {
                    $checked = '';
                    if (isset($mas[$value2['id']])) {
                        $checked = ' checked ';
                    }
                    $tmp .= '<input ' . $checked . ' type="radio" name="characteristics[' . $value->characteristics->id . ']" value="' . $value2['id'] . '"/>' . $value2->name;
                }
            } elseif ($type == 2) {
                $tmp .= '
                <p>' . $charact_name . '</p>';
                foreach ($value->characteristics->characteristicsData as $key2 => $value2) {
                    $checked = '';
                    if (isset($mas[$value2['id']])) {
                        $checked = ' checked ';
                    }
                    $tmp .= '<input ' . $checked . ' type="checkbox" name="characteristics[' . $value->characteristics->id . '][]" value="' . $value2['id'] . '"/>' . $value2->name;
                }
            } elseif ($type == 3) {
                $tmp .= '
                <p>' . $charact_name . '</p>';
                $tmp .= '<select class="form-control" name="characteristics[' . $value->characteristics->id . ']">';
                $tmp .= '<option selected disabled>Выберите</option>';
                foreach ($value->characteristics->characteristicsData as $key2 => $value2) {
                    $checked = '';
                    if (isset($mas[$value2['id']])) {
                        $checked = ' selected ';
                    }
                    $tmp .= '<option ' . $checked . ' value="' . $value2['id'] . '">' . $value2->name . '</option>';
                }
                $tmp .= '</select>';
            }

        }

        return $tmp;

    }

    function getcharacteristicsfilter($chars, $config = [])
    {
        if (isset($config['current_vals'])) {
            foreach ($config['current_vals'] as $key => $value) {
                $mas[$key] = $value;
            }
        }
        $tmp = '';
        foreach ($chars as $key => $value) {
            //если не показывать в фильтре то делаем след итерацию
            if ($value->characteristics->view_filter==0) continue;
            $f = 0;
            $type = $value->characteristics->type;
            $charact_name = $value->characteristics->name;
            if ($type == 0) {
                $test_str = CharacteristicsData::find()
                    ->where('parent_id=' . $value->characteristics->id . ' AND name<>"textinput"')
                    ->all();
                //теперь проверяем все ли значения это цифры что б понять испольовать его в фильтре или нет
                foreach ($test_str as $key9 => $value9) {
                    if (!intval($value9->name)) {
                        $f = 1;
                        break;
                    }
                }
                if ($f == 1) {
                    continue;
                }
                $min_val = '';
                $max_val = '';
                //получаем максимальное значение

                if (isset($config['current_vals'])) {
                    $tmpp = explode(',', $config['current_vals'][$value->characteristics->id]);
                    $min_val = $tmpp[0];
                    $max_val = $tmpp[1];
                }else{

                }
                $tmp .= '
                <div class="filter_item textinput">
                     <label class="main_label mh2">' . $charact_name . '</label>
                     <span class="minn">'.$min_val.'</span> <input  name="characteristics[' . $value->characteristics->id . ']" type="text" class="span2 ex2" value="" data-slider-min="0" data-slider-max="'.($value->characteristics->max_val ? $value->characteristics->max_val : 10000).'" data-slider-step="1" data-slider-value="[' . ($min_val ? $min_val : 0) . ',' . ($max_val ? $max_val : 10000) . ']"/><span class="maxx">'.$max_val.'</span>
                </div>';
                $tmp .= '<div class="clearfix"></div>';

            } elseif ($type == 1) {
                $tmp .= '
                <div class="filter_item radioinput">
                <label class="main_label mh2">' . $charact_name . '</label>
                <div class=" btn-group " data-toggle="buttons">';

                foreach ($value->characteristics->characteristicsData as $key2 => $value2) {
                    $checked = '';
                    $active = '';
                    if (isset($mas[$value->characteristics->id]) && $value2->id == $mas[$value->characteristics->id]) {
                        $checked = ' checked ';
                        $active = ' active ';
                    }
                    $tmp .= '<label class="btn btn-primary ' . $active . '"><input ' . $checked . ' type="radio" name="characteristics[' . $value->characteristics->id . ']" value="' . $value2['id'] . '"/>' . $value2->name . '</label>';
                }
                $tmp .= '</div>';
                $tmp .= '</div>';
                $tmp .= '<div class="clearfix"></div>';

            } elseif ($type == 2) {
                $tmp .= '
                <div class="filter_item checkboxx">
                <label class="main_label mh2">' . $charact_name . '</label>
                <div class=" btn-group " data-toggle="buttons">';
                foreach ($value->characteristics->characteristicsData as $key2 => $value2) {
                    $checked = '';
                    $active = '';


                    if (isset($mas[$value->characteristics->id]) && in_array($value2['id'], $mas[$value->characteristics->id])) {
                        $checked = ' checked ';
                        $active = ' active ';

                    }
                    $tmp .= '<label class="btn btn-primary ' . $active . '"><input ' . $checked . ' type="checkbox" name="characteristics[' . $value->characteristics->id . '][]" value="' . $value2['id'] . '"/>' . $value2->name . '</label>';
                }
                $tmp .= '</div>';
                $tmp .= '</div>';
                $tmp .= '<div class="clearfix"></div>';

            } elseif ($type == 3) {
                $tmp .= '
                <div class="filter_item select">
                <label class="main_label mh2">' . $charact_name . '</label>';
                $tmp .= '<select class="form-control" name="characteristics[' . $value->characteristics->id . ']">';
                $tmp .= '<option selected disabled>Выберите</option>';
                foreach ($value->characteristics->characteristicsData as $key2 => $value2) {
                    $checked = '';
                    if (isset($mas[$value->characteristics->id]) && $value2['id'] == $mas[$value->characteristics->id]) {
                        $checked = ' selected ';
                    }
                    $tmp .= '<option ' . $checked . ' value="' . $value2['id'] . '">' . $value2->name . '</option>';
                }
                $tmp .= '</select></div>';
                $tmp .= '<div class="clearfix"></div>';

            }

        }
        $tmp = '
        <form action="" method="POST">
          <input type="hidden" name="_csrf" value="123123123">

            ' . $tmp . '
            <p><button class="btn btn-default filter__submit" type="submit">Отфильтровать</button></p>
        </form>
        ';
        return $tmp;

    }

    public function getproducturl($product_id)
    {

        $product = Products::findOne($product_id);
        return $this->get_url($product->cat->cat_id) . '/view/' . $product->url . '_' . $product->id;
    }

    public function getproductbread($product_id)
    {
        $product = Products::findOne($product_id);
        return $this->getBread($product->cat->cat_id);
    }

    public function getproductimage($product_id)
    {
        $model = ImagesForProducts::find()->where(['product_id' => $product_id])->orderBy('id ASC')->one();
        if ($model) return $model->url;
        return false;
    }

    public function sendemail2($config = [])
    {
        $message = '
                        <html>
                            <head>
                                <title>' . $config['title'] . '</title>
                            </head>
                            <body>
                                ' . $config['text'] . '
                            </body>
                        </html>';

        Yii::$app->mailer->compose()
            ->setFrom('mehobr2016@gmail.com')
            ->setTo($config['to'])
            ->setSubject($config['subject'])
            ->setHtmlBody($message)
            ->send();
    }

    public function getProductTypes($cat_id)
    {
        $model = ProductTypesForCats::find()->where(['cat_id' => $cat_id])->orderBy('product_type_id DESC')->all();
        if ($model) return $model;
        $cat = Cats::findOne($cat_id);
        if ($cat->parent_id == 0) return false;
        while ($cat = Cats::findOne(['id' => $cat->parent_id])) {
            $model = ProductTypesForCats::find()->where(['cat_id' => $cat->id])->orderBy('product_type_id DESC')->all();
            if ($model) return $model;
        }
        return false;
    }


}

