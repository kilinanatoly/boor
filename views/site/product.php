<?php
use yii\widgets\Breadcrumbs;

$functons = new \app\models\Functions();
$bread = $functons->getproductbread($product->id);
foreach ($bread as $key => $value) {
    $this->params['breadcrumbs'][] = ['label' => $value['name'], 'url' => [$functons->get_url($value['id'])]];
}
$this->params['breadcrumbs'][] = $product->name;
$this->title = ($product->metatitle ? $product->metatitle : $product->name);
if ($product->metakeywords) {
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $product->metakeywords
    ]);
}
if ($product->metadescription) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $product->metadescription
    ]);
} ?>
<?= $this->render('/layouts/modals', [
    'product' => $product
]) ?>
<div class="container custom-breadcrumbs1">
    <div class="row">
        <div class="custom-breadcrumbs1__wrap">
            <div class="custom-breadcrumbs1__text">
                <div class="custom-breadcrumbs1__text_title">
                    <?= $product->name ?>
                </div>
                <div class="custom-breadcrumbs1__text_content">
                    <?= ($product->short_description ? $product->short_description : 'Просмотр описания и технических характеристик товара: "' . $product->name . '"') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container view-product">
    <div class="row">
        <div class="view-product__left">
            <div class="menu3">
                <div class="menu3__block1_wrap">
                    <div class="menu3__title">Каталог оборудования</div>
                    <div class="menu3__hr"></div>
                    <ul class="menu3__list">
                        <?php
                        $parents = $product->cats;
                        $functions = new \app\models\Functions();
                        $main_cats = \app\models\Cats::find()->where('parent_id=0')->all();
                        foreach ($main_cats as $key => $value) {
                            $url = $functions->get_url($value->id);
                            echo '<li class="menu3__list_item">
                         <a href="' . $url . '">' . $value->name . '</a>';
                            //показываем второй уровень если он есть
                            if ($value->childs) {
                                echo '<ul class="menu3__list_2" style="display:' . (in_array($value->id, $parents) ? 'block' : 'none') . '" >';
                                foreach ($value->childs as $key2 => $value2) {
                                    $url = $functions->get_url($value2->id);
                                    echo '<li class="menu3__list_2_item">
                                 <a ' . (in_array($value2->id, $parents) ? 'class="active"' : '') . 'href="' . $url . '">' . $value2->name . '</a>';
                                    //показываем третий уровень если он есть
                                    if ($value2->childs) {
                                        echo '<ul class="menu3__list_3" style="display:' . (in_array($value2->id, $parents) ? 'block' : 'none') . '">';
                                        foreach ($value2->childs as $key3 => $value3) {
                                            $url = $functions->get_url($value3->id);
                                            echo '<li class="menu3__list_3_item">
                                             <a ' . (in_array($value3->id, $parents) ? 'class="active"' : '') . 'href="' . $url . '">' . $value3->name . '</a>';
                                                if ($value3->childs) {
                                                    echo '<ul class="menu3__list_3" style="display:' . (in_array($value3->id, $parents) ? 'block' : 'none') . '">';
                                                    foreach ($value3->childs as $key4 => $value4) {
                                                        $url = $functions->get_url($value4->id);
                                                        echo '<li class="menu3__list_3_item">
                                                 <a ' . (in_array($value4->id, $parents) ? 'class="active"' : '') . 'href="' . $url . '">' . $value4->name . '</a>';
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
        <div class="view-product__right">
            <div class="product1__title">
                <h2 class="product1__name"><?= $product->name ?></h2>
                <?php
                if ($files) {
                    echo '<span class="product1__documentation1_span">(<a href="#" class="product1__documentation1"> Скачать документацию</a>)</span>';
                }
                ?>

                <a href="#" data-toggle="modal" data-target="#myModal3" class="btn btn-default btn3 product1__komm">Получить
                    коммерческое предложение</a>
                <div class="clearfix"></div>
            </div>

            <div class="product1-block1">
                <div class="product1-block1__left pmh1">
                    <div class="product1-block1__left_wrap">
                        <div class="product1__characteristics">
                            <h3>Технические характеристики:</h3>

                            <?php
                            if (!$product->characteristics){
                                echo '<div class="characteristics-notfound">Технические характеристики временно отсутствуют.</div>';
                            }
                            $mas = [];
                            foreach ($product->characteristics as $key => $value) {
                                $mas[$value->characterdata->characteristic->name][] =
                                    $value->characterdata->name;
                            }
                            if ($mas) {
                                echo '<div class="product1__characteristics_list">';
                                foreach ($mas as $key => $value) {
                                    if ($value) {
                                        $tmp = '';
                                        foreach ($value as $key2 => $value2) {
                                            $tmp .= $value2 . ',';
                                        }
                                        if ($key && $tmp) {
                                            echo '<p>' . $key . ': <span>' . trim($tmp, ',') . '</span></p>';
                                        }
                                    }
                                }
                                echo '</div>';
                            }

                            ?>

                            <div class="product1__pdf">
                                <p class="text-left">
                                    <!-- Web2PDF Converter Button BEGIN -->
                                    <script type="text/javascript">
                                        var
                                            pdfbuttonstyle = "custimg"
                                    </script>
                        <span id="syndicated-content"><a href="javascript:savePageAsPDF()" title="Скачать PDF документ"><img
                                    align="absmiddle" alt="Save web page to PDF free with www.web2pdfconvert.com"
                                    border="0" src="/images/site_images/pdf.jpg"></a></span>
                                    <script src="http://www.web2pdfconvert.com/pdfbutton2.js" id="Web2PDF"
                                            type="text/javascript"></script>
                                    <!-- Web2PDF Converter Button END -->

                                    <a href="javascript:window.print(); void 0;" title="Распечатать PDF документ"> <img
                                            src="/images/site_images/pechat.png"></a>

                                </p>
                            </div>
                            <div class="clearfix"></div>

                        </div>
                        <div class="product1-buttons">
                            <a href="#" data-toggle="modal" data-target="#myModal1"
                               class="btn btn-default btn1 product1__price_button">Узнать цену</a>
                            <a href="#" data-toggle="modal" data-target="#myModal2"
                               class="btn btn-default btn2 product1__spec_button">Проконсультироваться со
                                специалистом</a>
                        </div>
                        <?php

                        if ($product->short_description){
                            echo '<div class="product1___short"><div class="product1___short_title">Описание товара:</div>'.$product->short_description.'</div>';
                        }
                        if ($files) {
                            echo '<div class="product1-files">';
                            echo '<h2>Файлы для скачивания:</h2>';
                            foreach ($files as $key => $value) {
                                echo '
                                    <div class="product1-files_item">
                                        <a download="" target="_blank" href="' . Yii::$app->request->hostInfo . '/files/' . $value['product_id'] . '/' . $value['url'] . '">' . $value['url'] . '</a>
                                    </div>';
                            }
                            echo '</div>';
                        }
                        ?>
                        <div class="product1__short_border"><div class="product1__short_border_wrap"></div></div>
                    </div>
                </div>
                <div class="product1-block1__right pmh1">
                    <div class="product1__photo">
                        <div class="slider slider-for">
                            <?php
                            if (!$product->images) {
                                echo '
                                    <div>
                                        <img class="img-responsive product_image" src="/images/site_images/no_image.png">
                                    </div>';
                            }
                            foreach ($product->images as $key => $value) {
                                echo '
                                <div>
                                    <img class="img-responsive product_image" src="/images/products/' . $value['url'] . '">
                                </div>';
                            }

                            ?>
                        </div>
                        <div class="slider slider-nav">
                            <?php
                            if (!$product->images) {
                                echo '
                                    <div>
                                        <img class="img-responsive product_image" src="/images/site_images/no_image.png">
                                    </div>';
                            }
                            foreach ($product->images as $key => $value) {
                                echo '
                                <div>
                                    <img class="img-responsive product_image" src="/images/products/' . $value['url'] . '">
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="product1-right__border"><div class="product1-right__border_wrap"></div></div>
                </div>
            </div>
            <?php

            //если есть описание то выводим
            if ($product->description) {
                echo '
                    <div class="description product1__characteristics1">
                        <h2>Развернутое описание и технические характеристики:</h2>
                        ' . $product->description . '
                    </div>
                    ';
            }
            if ($product->description2) {
                echo '
                    <div class="product1__characteristics2">
                        <h2>Характеристики:</h2>
                        ' . $product->description2 . '
                    </div>
                    ';
            }
            //если есть похожие товары выводим
            /*if ($pohozhie){
                echo '
                <hr class="red_hr">
                <div class="pohozhie">
                    <h2>Похожие товары:</h2>';
                    foreach ($pohozhie as $key => $value) {
                        $url = $functons->getproducturl($value['id']);
                        $image = $functons->getproductimage($value['id']);
                        echo '
                            <div class="item">
                                <header>
                                    <a class="header_img" href="' . $url . '/view/' . $value->product->url . '_' . $value->product->id . '">
                                        <img src="/images/' . ($value->product->image->url ? 'products/' . $value->product->image->url : 'site_images/no_image.png') . '"  class="img-responsive" alt="' . $value->product->name . '">
                                    </a>
                                    <a class="item_name" href="' . $url . '/view/' . $value->product->url . '_' . $value->product->id . '">' . $value->product->name . '</a>';
                        echo '<div class="chars_items">';
                        foreach ($value->product->characteristics as $key2 => $value2) {
                            if ($value2->characterdata->characteristic->name && $value2->characterdata->name){
                                if ($key2>2) continue;
                                echo '<p>'.$value2->characterdata->characteristic->name.': '.$value2->characterdata->name.'</p>';
                            }
                        }
                        echo '</div>';
                        echo '
                                </header>
                                <footer>
                                    '.($value->product->price==0 ? 'Цена по запросу' : $value->product->price).'
                                </footer>
                            </div>
                        ';
                    }

                echo '</div>
                ';
            }*/
            ?>
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

