<?php

/* @var $this yii\web\View */

$this->title = 'Современное портативное оборудование для обработки металла';
$functions = new \app\models\Functions();
?>
    <div class="container site-index">
        <div class="row">
                <div class="site-index__wrap">
                    <div class="site-index__left">
                        <div class="menu1">
                            <div class="menu1__block1_wrap">
                                <div class="menu1__title">Каталог оборудования</div>
                                <div class="menu1__hr"></div>
                                <ul class="menu1__list">
                                    <?php
                                    foreach ($main_cats as $key=>$value) {
                                        $url = $functions->get_url($value->id);
                                        echo '<li class="menu1__list_item">
                                             <a href="'.$url.'">'.$value->name.'</a>
                                        </li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="menu1__search">
                                <?= $this->render('/layouts/poisk'); ?>
                            </div>
                        </div>

                    </div>
                    <div class="site-index__right">
                            <div class="index-catalog1">
                                <div class="index-catalog1__list">
                                    <?php
                                    foreach ($main_cats as $key=>$value) {
                                        $url = $functions->get_url($value->id);
                                        $tmp='';
                                        foreach ($value->childs as $key2=>$value2) {
                                            $url2 = $functions->get_url($value2->id);
                                            $tmp.='<a href="'.$url2.'">'.$value2->name.'</a>';

                                        }
                                        echo '
                                        <div class="index-catalog1__list_item">
                                            <div class="index-catalog1__list_item_content '.(($key%2==0 && $key<count($main_cats)-1) ? 'bordered' : '').' mh1">
                                                <div class="index-catalog1__list_item_img">
                                                    <a href="'.$url.'"><img src="/images/cats/'.$value->image.'" alt=""></a>
                                                </div>
                                                <div class="index-catalog1__list_item_cats">
                                                    <div class="index-catalog1__list_item_cats_first">
                                                        <a href="'.$url.'">'.$value->name.'</a>
                                                    </div>
                                                    <div class="index-catalog1__list_item_cats_second">
                                                        '.$tmp.'
                                                    </div>
                                                </div>
                                            </div>
                                            '.($key<count($main_cats)-1 ? '<div style="'.($key%2==0 ? 'float:left;' : 'float:right;').'" class="index-catalog1__list_item_border"></div>' : '').'
                                            
                                        </div>';
                                    }
                                    ?>

                                </div>
                            </div>
                    </div>

                </div>
        </div>
    </div>
