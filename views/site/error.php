<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $exception->getMessage();
if ($exception->statusCode == 403) {
    Url::remember();
}
?>
<div class="site-error">
    <div class="container">
        <div class="row">
            <h1>Что-то пошло не так.</h1>
            <div class="alert alert-danger">
                <?= $exception->getMessage(); ?>
            </div>
            <?php
            if ($exception->statusCode==404){
                echo '<p>Пожалуйста, вернитесь на <a href="/">Главную страницу</a>';
            }elseif ($exception->statusCode==403){
                echo '<p><a href="/login">Войти</a>';
            }
            ?>
        </div>
    </div>


</div>
