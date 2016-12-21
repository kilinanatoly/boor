<?php
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
$functions = new \app\models\Functions();
$this->title = $video->name;

$this->params['breadcrumbs'][] =['label'=>'Видеогалерея','url'=>'/videos'];
$this->params['breadcrumbs'][] = $this->title;


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
                        <h1><?=$this->title?></h1>
                    </header>
                    <div class="content">
                        <?php
                            echo $video->src;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
