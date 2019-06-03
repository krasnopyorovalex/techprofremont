<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * SelectAsset
 */
class SelectAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [
    ];
    public $js = [
        'js/plugins/forms/selects/bootstrap_select.min.js',
        'js/plugins/forms/selects/select2.min.js',
        'js/pages/form_select2.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
