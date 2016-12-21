<?php
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
$functions = new \app\models\Functions();
$this->title = 'Новинки и акции';
$this->params['breadcrumbs'][] = 'Новинки и акции'

?>
<div class="index-catalog-fluid">
    <div class="container articles-catalog">
        <div class="row">
            <div class="catalog">
                <div class="breadcrumbs1">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <h1 class="cat1__title">Новинки и акции</h1>
                </div>
                <div class="content static-text1">
                    <?php
                    if ($articles) {
                        foreach ($articles as $key => $value) {
                            $url = '/articles/' . $value->url;
                            echo '
                                <div class="news1__item">
                                    <div class="news1__item_left">
                                        <img src="/images/' . ($value->image ? 'articles/' . $value->image : 'site_images/no_image.png') . '"  class="img-responsive" alt="' . $value->name . '">
                                    </div>
                                    <div class="news1__item_right">
                                        <h2>' . $value->name . '</h2>
                                        <p class="news1__item_text">' . $value->text . '</p>
                                        <p class="news1__item_date">' . date('d.m.Y', strtotime($value->reg_date)) . '</p>
                                    </div>
                                </div>
                                <hr>
                            ';
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
