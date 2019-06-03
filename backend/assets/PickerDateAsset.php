<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * PickerDateAsset
 */
class PickerDateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/dashboard';
    public $css = [
    ];
    public $js = [
        'assets/js/plugins/ui/moment/moment.min.js',
        'assets/js/plugins/pickers/daterangepicker.js',
        'assets/js/pages/picker_date.js',
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
