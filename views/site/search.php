<?php

/* @var $this yii\web\View */

$this->title = 'Результаты поиска по запросу "'.$search.'""';
$functions = new \app\models\Functions();

$this->params['breadcrumbs'][] = 'Поиск по сайту';

?>
    <div class="container">
        <div class="row">
                <div class="catalog search-catalog">
                    <hr>
                    <header>
                        <?=$this->render('/layouts/poisk');?>
                    </header>
                    <div class="content">
                        <h2 class="search-catalog__title">Результаты поиска по запросу "<?=$search?>"</h2>
                        <?php
                        if (isset($data['cats'])){
                            echo '<hr>';
                            echo '<h3>Категории:</h3>';
                            echo '<div class="cats-items cats-items2">';
                            foreach ($data['cats'] as $key=>$value) {
                                $url = $functions->get_url($value->id);
                                echo '
                                <div class="cats-items__item ">
                                    <header class="cats-items__item_header">
                                        <a class="cats-items__item_header_a" href="'.$url.'">
                                            <img src="/images/cats/'.$value->image.'"  class="img-responsive" alt="'.$value->name.'">
                                        </a>
                                    </header>
                                    <footer>
                                        <a class="cats-items__item_a" href="'.$url.'">'.$value->name.'</a>
                                    </footer>
                                </div>
                            ';
                            }
                            echo '</div>';
                        }
                        if (isset($data['products'])){
                            echo '<hr>';
                            echo '<h3>Продукты:</h3>';
                            foreach ($data['products'] as $key=>$value) {
                                $url = $functions->getproducturl($value->id);
                                echo '
                                <div class="tovar1__item">
                                    <div class="tovar1__item_wrap '.(($key!=0 && ($key+1)%3==0 ) ? 'nobordered' : '').'">
                                        <a class="tovar1__item_name" href="'.$functions->getproducturl($value->id).'">'.$value->name .'</a>
                                        <div class="tovar1__item_left"> 
                                            <a  class="tovar1__item_left_a" href="' . $functions->getproducturl($value->id). '">
                                                <img src="/images/' . ($value->image->url ? 'products/' . $value->image->url : 'site_images/no_image.png') . '"  class="img-responsive tovar1__item_img" alt="' . $value->name . '">
                                            </a>
                                        </div>
                                        <div class="tovar1__item_right"> 
                                            <div class="tovar1__item_short">
                                                '.($value->short_description ? $value->short_description : 'Без описания').'
                                            </div>
                                            <div class="tovar1__item_more">
                                                 <a  href="'.$functions->getproducturl($value->id).'">Подробнее</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tovar1__item_border"><div class="tovar1__item_border_wrap"></div></div>
                                </div>
                            ';
                            }
                        }

                        if (!isset($data['products']) && !isset($data['cats'])){
                            echo '<h3>К сожалению, ничего не найдено</h3>';
                        }
                        ?>

                    </div>
                </div>
        </div>
    </div>
<hr>
<div class="container main_cons1">
    <div class="row">
        <div class="col-xs-12">
            <h1 class="main_cons1__title">Отправьте нам запрос на оборудование в 1 клик
                <span>и получите специальную цену!</span></h1>
            <form action="" method="post" id="form2">
                <div class="main_cons1__input">
                    <input type="text" name="name" class="form-control inline_block" placeholder="Ваше Имя *" required>
                </div>
                <div class="main_cons1__input">
                    <input type="text" name="tel" class="form-control inline_block " placeholder="Номер телефона *"
                           required>
                </div>
                <div class="main_cons1__input last">
                    <input type="text" name="name" class="form-control inline_block"
                           placeholder="Укажите, какое оборудование Вас интересует">
                </div>
                <div class="main_cons1__submit ">
                    <button type="submit" class="inline_block btn btn-default">Отправить запрос</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="container main-about2">
    <div class="row">
        <div class="main-about2__wrap">
            <div class="main-about2__title">
                <div class="main-about2__title_img">
                    <img src="/images/site_images/logo1.png" alt="">
                </div>
                <div class="main-about2__title_text">euroboor</div>
                <div class="main-about2__title_podtext">современное портативное оборудование</div>
            </div>
            <div class="main-about2__contacts">
                <div class="main-about2__contacts_call">
                    Позвонить:
                    <span>8 (800) 008-80-08</span>
                </div>
                <div class="main-about2__contacts_write">
                    Написать:
                    <span><a href="mailto:asd@mail@mail.ru">info@euroboor-rus.ru</a></span>
                </div>
                <div class="main-about2__contacts_see">
                    Посетить:
                    <span>Набережные Челны,
                    пр. мира, 123</span>
                </div>
            </div>
            <div class="main-about2__menu">
                <ul class="main-about2__menu_list">
                    <li class="main-about2__menu_list_item">
                        <a href="#">О компании</a>
                    </li>
                    <li class="main-about2__menu_list_item">
                        <a href="#">Каталог</a>
                    </li>
                    <li class="main-about2__menu_list_item">
                        <a href="#">Техподдержка</a>
                    </li>
                    <li class="main-about2__menu_list_item">
                        <a href="#">Контакты</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
