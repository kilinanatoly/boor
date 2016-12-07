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
    <title><?= Html::encode($this->title) ?> | Jet-stan.ru</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?=$this->render('modals')?>
    <?=$this->render('header')?>
    <?= $content ?>
    <?=$this->render('footer')?>

</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
