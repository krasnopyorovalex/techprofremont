<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class CheckboxListAsset
 * @package backend\assets
 */
class CheckboxListAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard/assets';
    public $css = [];
    public $js = [
        'js/pages/checkbox_list.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
