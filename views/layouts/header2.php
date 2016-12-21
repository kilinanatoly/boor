<?php
//Вытаскиваем главные категории лдля выпадающего меню
$cats = \app\models\Cats::find()->where('parent_id=0')->all();
?>
<div class="container top_menu">
    <div class="row">
        <div class="col-xs-12">
            <ul>
                <li class="home">
                    <a href="/">
                        <img src="/images/site_images/home.png" alt="На главную">
                    </a>
                </li>
                <li class="dropdown">
                    <a id="drop4" role="button" data-toggle="dropdown" href="#">Каталог продукции<b class="caret"></b></a>
                    <?php
                    if ($cats){
                        $functions = new \app\models\Functions();
                        echo '<ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
                          <img src="/images/site_images/str.png" class="str" >';
                        foreach ($cats as $key=>$value) {
                            echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="'.$functions->get_url($value->id).'" >'.$value->name.'</a></li>';
                        }
                        echo '</ul>';

                    }
                    ?>
                </li>
                <li>
                    <a href="/uslugi">Услуги</a>
                </li>
                <li>
                    <a href="/company">О компании</a>
                </li>
                <li>
                    <a href="/videos">Видеогалерея</a>
                </li>
                <!--<li>
                    <a href="/articles">Статьи</a>
                </li>-->
                <li>
                    <a href="/contacts">Контакты</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container top-header">
    <div class="row">
        <div class="col-xs-4 block1">
            <a href="/">
                <img src="/images/site_images/logo.png" alt="Логотип">
            </a>
        </div>
        <div class="col-xs-3 block2">
            <div class="tel">
                <img src="/images/site_images/phone.png" alt="Телефон">
            </div>
            <div class="text">
                <p>8 (800) 250-02-16</p>
                <!--<p>+7 (800) 450-65-45</p>
                <p>+7 (800) 450-65-45</p>-->
            </div>
            <div class="postfix">
                Бесплатно по России
            </div>
        </div>
        <div class="col-xs-3 block3">
            <div class="prefix">
                <img src="/images/site_images/samolet.png" alt="Почта">
                <div class="clearfix"></div>
                <img src="/images/site_images/clock.png" alt="График работы">
            </div>
            <div class="text">
                <p class="email">info@azimut-ltd.ru</p>
                <p class="email">8:00 - 17:00 <span>пн-пт</span></p>
            </div>
        </div>
        <div class="col-xs-2 block4">
            <a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal4">Обратный звонок</a>
            <!--<a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModal5" >Оставить заявку</a>-->
        </div>
    </div>
</div>
<div class="container  header2 top-sliderr">
    <div class="row">
        <div class="col-xs-12">
            <h1>Продажа Станков и оборудования для механической обработки деталей</h1>
            <form action="/site/search" method="get">
                <?php
                use kartik\typeahead\Typeahead;
                use yii\helpers\Url;
                echo Typeahead::widget([
                    'name' => 'search',
                    'options' => [
                        'placeholder' => 'Найдите необходимое Вам оборудование',
                    ],
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'templates' => [
                                'header' => '<h3 class="league-name">Категории</h3>'
                            ],
                            'remote' => [
                                'url' => Url::to(['ajax/cats-list']) . '?q=%QUERY',
                                'wildcard' => '%QUERY'
                            ]
                        ],
                        [
                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                            'display' => 'value',
                            'templates' => [
                                'header' => '<h3 class="league-name">Продукты</h3>'
                            ],
                            'remote' => [
                                'url' => Url::to(['ajax/products-list']) . '?q=%QUERY',
                                'wildcard' => '%QUERY'
                            ]
                        ]
                    ]
                ]);
                ?>
                <button type="submit"><span class="glyphicon glyphicon-search"></span><span class="search" style="padding-left:10px;">Найти</span></button>
            </form>
        </div>

    </div>
</div>