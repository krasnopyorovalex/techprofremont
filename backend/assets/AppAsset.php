<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [
        //'https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900',
        'css/bootstrap.min.css',
        'css/icons/icomoon/styles.css',
        'css/core.min.css',
        'css/components.min.css',
        'css/colors.min.css',
        'css/override.css',
    ];
    public $js = [
        'js/plugins/loaders/pace.min.js',
        'js/core/libraries/bootstrap.min.js',
        'js/plugins/loaders/blockui.min.js',
        'js/core/app.min.js',
        'js/pages/form_bootstrap_select.js',
        'js/plugins/forms/selects/bootstrap_select.min.js',
        'js/core/user_scripts.js',
        'js/plugins/notifications/jgrowl.min.js',
        //'js/pages/dashboard.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}