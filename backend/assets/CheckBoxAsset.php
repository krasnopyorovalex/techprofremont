<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * CheckBoxAsset
 */
class CheckBoxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [
    ];
    public $js = [
        'js/plugins/forms/styling/uniform.min.js',
        'js/plugins/forms/styling/switchery.min.js',
        'js/plugins/forms/styling/switch.min.js',
        'js/pages/form_checkboxes_radios.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
