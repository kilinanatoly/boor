<?php
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
$functions = new \app\models\Functions();
$this->title = $cat->name;
$bread = $functions->getBread($cat->id);
if (count($bread) > 1) {
    foreach ($bread as $key => $value) {
        if (count($bread) - 1 == $key) continue;
        $this->params['breadcrumbs'][] = ['label' => $value['name'], 'url' => [$functions->get_url($value['id'])]];
    }
}
$this->params['breadcrumbs'][] = $cat->name;

?>
<div class="container custom-breadcrumbs1">
    <div class="row">
        <div class="custom-breadcrumbs1__wrap">
            <div class="custom-breadcrumbs1__text">
                <div class="custom-breadcrumbs1__text_title">
                    <?=$cat->name?>
                </div>
                <div class="custom-breadcrumbs1__text_content">
                    <?=($cat->description ? $cat->description : 'Просмотр категории "'.$cat->name.'"')?>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="container products1">
        <div class="row">
            <div class="products1__wrap">
                    <div class="products1__wrap_left">
                        <div class="menu3">
                            <div class="menu3__block1_wrap">
                                <div class="menu3__title">Каталог оборудования</div>
                                <div class="menu3__hr"></div>
                                <ul class="menu3__list">
                                    <?php

                                    $main_cats = \app\models\Cats::find()->where('parent_id=0')->all();
                                    foreach ($main_cats as $key=>$value) {
                                        $url = $functions->get_url($value->id);
                                        echo '<li class="menu3__list_item">
					                    <a href="'.$url.'">'.$value->name.'</a>';
                                        //показываем второй уровень если он есть
                                        if ($value->childs){
                                            echo '<ul class="menu3__list_2" style="display:'.(in_array($value->id,$cat->parents) ? 'block' : 'none').'" >';
                                            foreach ($value->childs as $key2=>$value2) {
                                                $url = $functions->get_url($value2->id);
                                                echo '<li class="menu3__list_2_item">
					                            	 <a '.($cat->id==$value2->id ? 'class="active"' : '').'href="' . $url . '">' . $value2->name . '</a>';
                                                //показываем третий уровень если он есть
                                                if ($value2->childs){
                                                    echo '<ul class="menu3__list_3" style="display:'.(in_array($value2->id,$cat->parents) ? 'block' : 'none').'">';
                                                    foreach ($value2->childs as $key3=>$value3) {
                                                        $url = $functions->get_url($value3->id);
                                                        echo '<li class="menu3__list_3_item">
				                                    	 <a '.($cat->id==$value3->id ? 'class="active"' : '').' href="' . $url . '">' . $value3->name . '</a>';
                                                        echo '</li>';
                                                    }
                                                    echo '</ul>';
                                                }
                                                echo '</li>';
                                            }
                                            echo '</ul>';
                                        }

                                        echo '</li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="menu3__search">
                                <?= $this->render('/layouts/poisk'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="products1__wrap_right">
                        <?php
                        $view_table = '';
                        $view_blocks = [];
                        //проверям пришел ли гет параметр как выодить продукты
                        if (Yii::$app->request->get('view')) {
                            $view_flag = Yii::$app->request->get('view');
                        } else {
                            $view_flag = $cat->view_type;
                        }
                        if (!$view_flag) $view_flag = 'table';
                        $view_blocks[] = 'view=blocks';
                        if (Yii::$app->request->get('page')) {
                            $view_blocks[] = 'page=' . Yii::$app->request->get('page');
                        }
                        if (Yii::$app->request->get('per-page')) {
                            $view_blocks[] = 'per-page=' . Yii::$app->request->get('per-page');
                        }
                        $view_blocks = implode('&', $view_blocks);

                        $view_table[] = 'view=table';
                        if (Yii::$app->request->get('page')) {
                            $view_table[] = 'page=' . Yii::$app->request->get('page');
                        }
                        if (Yii::$app->request->get('per-page')) {
                            $view_table[] = 'per-page=' . Yii::$app->request->get('per-page');
                        }
                        $view_table = implode('&', $view_table);

                        if ($products) {
                            echo '<div class="filter1">
                            <p class="show_filter"><a href="#" class="btn btn-default flag filter-button1">Показать фильтр</a><span><a class="btn btn-default filter-button2  ' . ($view_flag == 'table' ? ' active ' : '') . '" href="?' . $view_table . '">Показать списком</a></span> <span><a  class="btn btn-default filter-button3 ' . ($view_flag == 'blocks' ? ' active ' : '') . '" href="? ' . $view_blocks . '">Показать блоками</a></span></p>
                            <div class="filter1">
                               ' . $filter . '
                            </div>
                        </div>';
                            if ($view_flag == 'blocks') {
                                foreach ($products as $key => $value) {

                                    $current_chars = $value->product->characteristics;
                                    $tmp = [];
                                    foreach ($current_chars as $key2 => $value2) {
                                        $tmp[$value2->characterdata->parent_id][] = $value2->characterdata->name;
                                    }
                                    $res = '';
                                    //тут в цикле выводим данные продукта, а если нету то прочерк
                                    //на данный момент данные хранятся в tmp
                                    foreach ($all_chars as $key4 => $value4) {
                                        if (isset($tmp[$key4])) {
                                            $val = implode(', ', $tmp[$key4]);
                                            $res.= '<p>'.$value4->characteristics->name.'' . '<span>'.$val . '</span></p>';
                                        }
                                    }


                                    if (!$value->product) continue;
                                    $url = $functions->get_url($value->cat_id);
                                echo '
                                <div class="tovar1__item">
                                    <div class="tovar1__item_wrap '.(($key!=0 && ($key+1)%3==0 ) ? 'nobordered' : '').'">
                                        <a class="tovar1__item_name" href="'.$functions->getproducturl($value->product->id).'">'.$value->product->name .'</a>
                                        <div class="tovar1__item_left"> 
                                            <a  class="tovar1__item_left_a" href="' . $functions->getproducturl($value->product->id). '">
                                                <img src="/images/' . ($value->product->image->url ? 'products/' . $value->product->image->url : 'site_images/no_image.png') . '"  class="img-responsive tovar1__item_img" alt="' . $value->product->name . '">
                                            </a>
                                        </div>
                                        <div class="tovar1__item_right"> 
                                            <div class="tovar1__item_short">
                                                '.($value->product->short_description ? $value->product->short_description : 'Без описания').'
                                            </div>
                                            <div class="tovar1__item_more">
                                                 <a  href="'.$functions->getproducturl($value->product->id).'">Подробнее</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tovar1__item_border"><div class="tovar1__item_border_wrap"></div></div>
                                </div>
                            ';
                                }
                            } elseif ($view_flag == 'table') {
                                echo '
                            <table class="table table-bordered tovars1__table ">
                                  <thead>
                                    <tr>
                                      <th class="text-center">Название</th>';
                                foreach ($products as $key => $value) {
                                    //получаем прикрепленные к ПРОДУКТУ тех.характеристики
                                    $current_chars = $value->product->characteristics;

                                    $tmp = [];
                                    foreach ($current_chars as $key2 => $value2) {
                                        $tmp[$value2->characterdata->parent_id][] = $value2->characterdata->name;
                                    }
                                }
                                //тут выводим шапку таблицы
                                foreach ($all_chars as $key => $value) {
                                    if (isset($tmp[$key])) {
                                        echo '<th class="text-center">' . $value->characteristics->name . '</th>';
                                        continue;
                                    } else {
                                        echo '<th class="text-center">' . $value->characteristics->name . '</th>';
                                    }
                                }
                                echo '</tr>
                                  </thead>
                                  <tbody>';
                                //тут мы получаем продукты
                                foreach ($products as $key => $value) {
                                    //получаем прикрепленные к ПРОДУКТУ тех.характеристики
                                    $current_chars = $value->product->characteristics;
                                    $tmp = [];
                                    foreach ($current_chars as $key2 => $value2) {
                                        $tmp[$value2->characterdata->parent_id][] = $value2->characterdata->name;
                                    }
                                    //тут выводим строку
                                    echo '<tr>';
                                    echo '<td><a href="' . $functions->getproducturl($value->product->id) . '"> ' . $value->product->name . '</a></td>';
                                    //тут в цикле выводим данные продукта, а если нету то прочерк
                                    //на данный момент данные хранятся в tmp
                                    foreach ($all_chars as $key4 => $value4) {
                                        if (isset($tmp[$key4])) {
                                            $val = implode(', ', $tmp[$key4]);
                                            echo '<td>' . $val . '</td>';
                                        } else {
                                            $val = '&mdash;';
                                            echo '<td>' . $val . '</td>';
                                        }
                                    }
                                    echo '</tr>';

                                }
                                echo '
                                  </tbody>
                                </table>
                            ';
                            }

                            echo '<div class="clearfix"></div>';
                            echo '<div class="pagination1">'.LinkPager::widget([
                                    'pagination' => $pages,
                                ]).'</div>';
                        } else {
                            if (Yii::$app->request->post('characteristics')){
                                echo '<div class="filter1__not_found"><h4>По данному фильтру продуктов не найдено</h4>
                                <p><a href="'.Yii::$app->request->url.'">Сбросить фильтр</a> </p></div>';

                            }else{
                                echo '<h4>В данной категории продуктов нет</h4>';
                            }
                        }

						if ($cat->text_information){
							echo '
								<div class="text_information">
								' . $cat->text . '
								</div>
								';
						}
                        echo '</div>';

                        ?>

                    </div>
            </div>
        </div>
<hr>
<div class="container main_cons1">
    <div class="row">
        <div class="col-xs-12">
            <h1 class="main_cons1__title" >Отправьте нам запрос на оборудование в 1 клик
                <span>и получите специальную цену!</span></h1>
            <form action="" method="post" id="form2">
                <div class="main_cons1__input">
                    <input type="text" name="name" class="form-control inline_block" placeholder="Ваше Имя *" required>
                </div>
                <div class="main_cons1__input">
                    <input type="text" name="tel" class="form-control inline_block " placeholder="Номер телефона *" required>
                </div>
                <div class="main_cons1__input last">
                    <input type="text" name="name" class="form-control inline_block" placeholder="Укажите, какое оборудование Вас интересует">
                </div>
                <div class="main_cons1__submit ">
                    <button type="submit" class="inline_block btn btn-default">Отправить запрос</button>
                </div>
            </form>
        </div>
    </div>
</div>
