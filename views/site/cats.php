<?php
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
$functions = new \app\models\Functions();
$this->title = ($cat->metatitle? $cat->metatitle : $cat->name);
if ($cat->metakeywords){
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $cat->metakeywords
    ]);
}
if ($cat->metadescription){
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $cat->metadescription
    ]);
}
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

<div class="catalog-cats container ">
    <div class="row">
        <div class="catalog-cats__left">
            <div class="menu2">
                <div class="menu2__block1_wrap">
                    <div class="menu2__title">Каталог оборудования</div>
                    <div class="menu2__hr"></div>
                    <ul class="menu2__list">
                        <?php

                        $main_cats = \app\models\Cats::find()->where('parent_id=0')->all();
                        foreach ($main_cats as $key=>$value) {
                            $url = $functions->get_url($value->id);
                            echo '<li class="menu2__list_item">
                         <a href="'.$url.'">'.$value->name.'</a>';
                         //показываем второй уровень если он есть
                         if ($value->childs){
                             echo '<ul class="menu2__list_2" style="display:'.(in_array($value->id,$cat->parents) ? 'block' : 'none').'" >';
                             foreach ($value->childs as $key2=>$value2) {
                                 $url = $functions->get_url($value2->id);
                                 echo '<li class="menu2__list_2_item">
                                 <a '.($cat->id==$value2->id ? 'class="active"' : '').'href="' . $url . '">' . $value2->name . '</a>';
                                     //показываем третий уровень если он есть
                                     if ($value2->childs){
                                         echo '<ul class="menu2__list_3" style="display:'.(in_array($value2->id,$cat->parents) ? 'block' : 'none').'">';
                                         foreach ($value2->childs as $key3=>$value3) {
                                             $url = $functions->get_url($value3->id);
                                             echo '<li class="menu2__list_3_item">
                                             <a href="' . $url . '">' . $value3->name . '</a>';
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
                <div class="menu2__search">
                    <?= $this->render('/layouts/poisk'); ?>
                </div>
            </div>
        </div>
        <div class="catalog-cats__right">
            <div class="cats-list1">
                <?php
                foreach ($cats as $key => $value) {
                    if ($key!=0 && $key%4==0){
                        //echo '<hr>';
                    }
                    $url = $functions->get_url($value->id);
                    echo '
                        <div class="cats-list1__item ">
                            <div class="cats-list1__item_wrap mh2">
                                 <header class="cats-list1__item_header">
                                    <a class="cats-list1__item_header_a" href="' . $url . '">
                                    '.(($value->image && file_exists('images/cats/' . $value->image . '')) ? '<img src="/images/cats/' . $value->image . '"  class="img-responsive" alt="' . $value->name . '">' : '<img src="/images/site_images/no_image.png"  class="img-responsive" alt="' . $value->name . '">').'
                                        
                                    </a>
                                 </header>
                                 <hr>
                                 <footer class="cats-list1__item_footer">
                                    <a class="cats-list1__item_a" href="' . $url . '">' . $value->name . '</a>
                                 </footer>
                            </div>
                        </div>
                         ';
                }
                //если текстовая информация то ее выводим
                if ($cat->text_information == 1) {
                    echo '
                    <div class="text_information">
                    ' . $cat->text . '
                    </div>
                    ';
                }

                ?>
            </div>
        </div>
    </div>
</div>


