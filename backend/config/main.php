<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
    ],
    'modules' => require(__DIR__ . '/modules.php'),
    'language' => 'ru',
    'homeUrl' => '/_root/',
    'timeZone'=>'Europe/Moscow',
    'container' => [
        'singletons' => [
            'backend\components\UploadInterface' => 'backend\components\UploadService'
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/_root',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'krasber-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '/' => 'site/index',
                '<action:(login|logout|upload-ckeditor|multiupload)>' => 'site/<action>',
                '<_m:[\wd-]+>/<action:(update-pos-items)>' => '<_m>/items/<action>',
                '<_m:[\wd-]+>/<action:(items|add-item|edit-item|delete-item)>/<id:\d+>' => '<_m>/items/<action>',
                '<_m:[\wd-]+>' => '<_m>/default/index',
                '<_m:[\wd-]+>/<action:[\wd-]+>/<id:[\d]+>' => '<_m>/default/<action>',
                '<_m:[\wd-]+>/<action:[\wd-]+>' => '<_m>/default/<action>',
            ],
        ],
    ],
    'params' => $params,
];
