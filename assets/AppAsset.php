<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/polzunok/css/bootstrap-slider.min.css',
        'css/site.css',
        'css/slick/slick.css',
        'css/slick/slick-theme.css',
    ];

    public $js = [
        'js/slick.min.js',
        'js/script.js',
        'js/jquery.matchHeight-min.js',
        'js/polzunok/bootstrap-slider.min.js',


    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset'
    ];
    public $publishOptions = [
        'forceCopy'=>true,
    ];
}
