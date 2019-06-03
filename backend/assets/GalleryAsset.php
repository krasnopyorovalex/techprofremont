<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * GalleryAsset
 */
class GalleryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [
    ];
    public $js = [
        'js/plugins/forms/styling/switchery.min.js',
        'js/plugins/forms/styling/uniform.min.js',
        'js/plugins/media/fancybox.min.js',
        'js/pages/components_thumbnails.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
