<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
    AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=1280">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> | Euroboor-rus.ru</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?=$this->render('modals')?>
    <?= $this->render('header')?>
    <?=$this->render('slider1')?>
    <?= $content ?>
    <?=$this->render('preim1')?>
    <?=$this->render('main_about')?>
    <?=$this->render('kons')?>
    <?=$this->render('main_about2')?>
    <?=$this->render('footer')?>
    <?/*=$this->render('footer2')*/?>

</div>


<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
