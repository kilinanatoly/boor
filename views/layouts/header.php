<?php
//Вытаскиваем главные категории лдля выпадающего меню
$cats = \app\models\Cats::find()->where('parent_id=0')->all();
?>
<div class="container-fluid header1__wrap_fluid">
    <div class="container header1__wrap">
        <div class="row">
            <div class="header1__line1">
                <div class="header1__line1_number">
                    8 (800) 250-02-16
                </div>
                <div class="header1__line1_email">
                    <a href="mailto:mail@euroboor-rus.ru." style="box-sizing: border-box; color: #f9f9f9;; line-height: 17px; outline: 0px; font-family: PFDIN; font-size: 17px;" title="mail@euroboor-rus.ru">mail@euroboor-rus.ru</a>
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

                    <div class="header2__logo_left">
                        <a href="/" title="Главная"></a>
                    </div>

                    </div>

                    </div>




</div>

            <div class="header2__menu">
                <ul class="header2__menu_list">
                    <li class="header2__menu_list_item">
                        <a href="/info/company">О компании</a>
                    </li>
                    <li class="header2__menu_list_item">
                        <a href="/catalog">Каталог</a>
                    </li>
                    <li class="header2__menu_list_item">
                        <a href="/info/	servis">Техподдержка</a>
                    </li>
                    <li class="header2__menu_list_item">
                        <a href="/info/contacts">Контакты</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

