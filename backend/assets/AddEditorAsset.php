<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * AddEditorAsset
 */
class AddEditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard';
    public $css = [
    ];
    public $js = [
        'ckeditor/ckeditor.js',
        'assets/js/pages/editor_ckeditor_single_add.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
