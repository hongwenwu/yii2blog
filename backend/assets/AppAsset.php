<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'statics/css/font-awesome-4.4.0/css/font-awesome.css',
        'statics/css/layout.css',
        'statics/css/toggles-full.css',
        'statics/css/weather-icons.css',
        'statics/css/site.css',
    ];
    public $js = [
        'statics/js/jquery-ui.js',
        'statics/js/layout.js',
        'statics/js/toggles.js',
        'statics/js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
