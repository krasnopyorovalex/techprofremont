<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * SelectBootstrapAsset
 */
class SelectBootstrapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [
    ];
    public $js = [
        'js/plugins/forms/styling/uniform.min.js',
        'js/plugins/forms/selects/bootstrap_multiselect.js',
        'js/plugins/notifications/pnotify.min.js',
        'js/pages/form_multiselect.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
