<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * DnDAsset
 */
class DnDAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [
    ];
    public $js = [
        'js/plugins/ui/dragula.min.js',
        'js/plugins/forms/selects/select2.min.js',
        'js/plugins/forms/styling/uniform.min.js',
        'js/pages/extension_dnd.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
