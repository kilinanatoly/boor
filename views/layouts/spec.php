<div class="container spec1">
    <div class="row">
        <div class="breadcrumb1">
            <div class="breadcrumb1__yellow">
                <span>Каталог техники</span>
            </div>
            <div class="breadcrumb1__black">
                <span>Популярные модели</span>
            </div>
        </div>
        <div class="spec1__list spec-slider">
            <?php
            $products = \app\models\Products::find()
                ->where('spec=1 AND active=1')
                ->orderBy('id DESC')
                ->all();
            if ($products){
                $functions = new \app\models\Functions();
                foreach ($products as $key5 => $value5) {
                    $res = '';
                    $mas = [];
                    foreach ( $value5->characteristics as $key=>$value  ) {
                        
                        $mas[$value->characterdata->characteristic->name][] =
                            $value->characterdata->name;
                    }
                    if ($mas){
                        $res='<div class="characteristics">';
                        foreach ($mas as $key => $value) {
                            if ($value){
                                $tmp = '';
                                foreach ($value as $key2 => $value2) {
                                    $tmp.=$value2.',';
                                }
                                if ($key && $tmp){
                                    $res.= '<p>'.$key.': <span>'.trim($tmp,',').'</span></p>';
                                }
                            }
                        }
                        $res.='</div>';
                    }
                    echo '
                    <div class="spec1__item">
                         <div class="spec1__item_wrap">
                            <header class="tovar1__item_header">
                                <a class="tovar1__item_header_a" href="'.$functions->getproducturl($value5->id).'">
                                   <img src="/images/' . ($value5->image->url ? 'products/' . $value5->image->url : 'site_images/no_image.png') . '"  class="img-responsive tovar1__item_img" alt="' . $value5->name . '">
                                </a>
                            </header>
                            <p class="spec1__item_name"><a href="'.$functions->getproducturl($value5->id).'">'.$value5->name.'</a></p>
                            '.((isset($res) && !empty($res)) ? '<div class="spec1__item_chars">'.$res.'</div>' : '').'
                            <p class="spec1__item_price"> '.($value5->price ? $value5->price.' рублей' : '').'</p>
                            <!--<p><a href="#" data-toggle="modal" data-target="#myModal6" data-name="'.$value5->name.'" data-product_id = "'.$value5->id.'" class="btn btn-default ost">Оставить заявку</a></p>-->
                         </div>
                    </div>
                    ';
                }

            }
            ?>
        </div>
    </div>
</div>