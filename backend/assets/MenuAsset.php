<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * MenuAsset
 */
class MenuAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [
        'js/menu/jquery-ui.min.css'
    ];
    public $js = [
        'js/menu/jquery-ui.min.js',
        'js/menu/jquery.mjs.nestedSortable.js',
        'js/menu/client_actions_nestedSortable.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
