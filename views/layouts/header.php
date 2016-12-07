<?php
//Вытаскиваем главные категории лдля выпадающего меню
$cats = \app\models\Cats::find()->where('parent_id=0')->all();
?>
<div class="container-fluid header1__wrap_fluid">
    <div class="container header1__wrap">
        <div class="row">
            <div class="header1__line1">
                <div class="header1__line1_number">
                    8 (800) 800-00-00
                </div>
                <div class="header1__line1_email">
                    info@euroboor-rus.ru
                </div>
                <div class="header1__line1_obrat">
                    <a href="#" data-toggle="modal" data-target="#myModal4" class="perezvon">Заказать обратный звонок</a>
                </div>
                <div class="header1__line1_search">
                    <?= $this->render('/layouts/poisk'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid header2__wrap_fluid">
    <div class="container header2__wrap">
        <div class="row">
            <div class="header2__logo">
                <a href="/">
                    <div class="header2__logo_left">
                        <img src="/images/site_images/logo1.png" alt="Логотип">
                    </div>
                    <div class="header2__logo_right">
                        <span class="header2__logo_right_span1">EURO</span>
                        <span class="header2__logo_right_span2">BOOR</span>
                    </div>
                </a>
            </div>
            <div class="header2__menu">
                <ul class="header2__menu_list">
                    <li class="header2__menu_list_item">
                        <a href="#">О компании</a>
                    </li>
                    <li class="header2__menu_list_item">
                        <a href="/catalog">Каталог</a>
                    </li>
                    <li class="header2__menu_list_item">
                        <a href="#">Техподдержка</a>
                    </li>
                    <li class="header2__menu_list_item">
                        <a href="#">Контакты</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

