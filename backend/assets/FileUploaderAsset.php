<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * FileUploaderAsset
 */
class FileUploaderAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [
    ];
    public $js = [
        'js/plugins/uploaders/fileinput.min.js',
        'js/pages/uploader_bootstrap.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
