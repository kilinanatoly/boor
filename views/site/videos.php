<?php
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
$functions = new \app\models\Functions();
$this->title = 'Видеогалерея';

$this->params['breadcrumbs'][] = 'Видеогалерея'


?>
<div class="container-fluid index-catalog-fluid">
    <div class="container index-catalog cats-catalog">
        <div class="row">
            <div class="col-xs-12">
                <div class="catalog">
                    <header>
                        <?= Breadcrumbs::widget([
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]) ?>
                        <h1>Видеоролики</h1>
                    </header>
                    <div class="content">
                        <?php
                        foreach ($videos as $key=>$value) {
                            $url = '/videos/'.$value->url;
                            echo '
                                <div class="item">
                                    <header>
                                        <a href="'.$url.'">
                                            <img src="/images/videos/'.$value->image.'"  class="img-responsive" alt="'.$value->name.'">
                                        </a>
                                    </header>
                                    <footer>
                                        <a href="'.$url.'">'.$value->name.'</a>
                                    </footer>
                                </div>
                            ';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
