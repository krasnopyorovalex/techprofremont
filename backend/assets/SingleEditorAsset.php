<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * SingleEditorAsset
 */
class SingleEditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard';
    public $css = [
    ];
    public $js = [
        'ckeditor/ckeditor.js',
        'assets/js/pages/editor_ckeditor_single.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
