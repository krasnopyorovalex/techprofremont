<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * TagsInputAsset
 */
class TagsInputAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [
    ];
    public $js = [
        'js/plugins/forms/tags/tagsinput.min.js',
        'js/pages/tags_input.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
