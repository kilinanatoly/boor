<?php
$this->title = 'Каталог оборудования';
?>
<div class="container custom-breadcrumbs1">
    <div class="row">
        <div class="custom-breadcrumbs1__wrap">
            <div class="custom-breadcrumbs1__text">
                <div class="custom-breadcrumbs1__text_title">
                    Каталог оборудования
                </div>
                <div class="custom-breadcrumbs1__text_content">
                   Выберите интересующую Вас продукцию из каталога по лучшим ценам в регионе!
                </div>
            </div>
        </div>
    </div>
</div>
<div class="catalog1">
    <div class="container">
        <div class="row">
            <div class="index-catalog2">
                <div class="index-catalog2__list">
                    <?php
                    $functions = new \app\models\Functions();
                    foreach ($main_cats as $key=>$value) {
                        $url = $functions->get_url($value->id);
                        $tmp='';
                        foreach ($value->childs as $key2=>$value2) {
                            $url2 = $functions->get_url($value2->id);
                            $tmp.='<a href="'.$url2.'">'.$value2->name.'</a>';

                        }
                        echo '
                                        <div class="index-catalog2__list_item">
                                            <div class="index-catalog2__list_item_content '.(($key%2==0 && $key<count($main_cats)-1) ? 'bordered' : '').' mh1">
                                                <div class="index-catalog2__list_item_img">
                                                    <a href="'.$url.'"><img src="/images/cats/'.$value->image.'" alt=""></a>
                                                </div>
                                                <div class="index-catalog2__list_item_cats">
                                                    <div class="index-catalog2__list_item_cats_first">
                                                        <a href="'.$url.'">'.$value->name.'</a>
                                                    </div>
                                                    <div class="index-catalog2__list_item_cats_second">
                                                        '.$tmp.'
                                                    </div>
                                                </div>
                                            </div>
                                            '.($key<count($main_cats)-1 ? '<div style="'.($key%2==0 ? 'float:left;' : 'float:right;').'" class="index-catalog2__list_item_border"></div>' : '').'
                                            
                                        </div>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>