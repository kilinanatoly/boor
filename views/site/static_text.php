<?php
use yii\widgets\Breadcrumbs;
/* @var $this yii\web\View */
$functions = new \app\models\Functions();
$this->title = $data->name;

$this->params['breadcrumbs'][] = $this->title;


?>
<div class="index-catalog-fluid">
    <div class="container articles-catalog">
        <div class="row">
            <div class="breadcrumbs1">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <h1 class="cat1__title"><?=$this->title?></h1>
            </div>
            <div class="static-text1">
                <?php
                    echo $data->text;
                ?>
            </div>
        </div>
    </div>
</div>
