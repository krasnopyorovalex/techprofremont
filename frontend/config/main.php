<?php

use frontend\components\RedirectorService;
use common\models\User;
use frontend\services\SendService;
use yii\log\FileTarget;
use yii\web\View;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-techprofremont',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru',
    'timeZone'=>'Europe/Moscow',
    'on beforeRequest' => static function () {
        (new RedirectorService())->parse();
    },
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-techprofremont',
            'baseUrl' => ''
        ],
        'sender' => [
            'class' => SendService::class,
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'frontend-techprofremont',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
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
                //for main domain
                '/' => 'site',
                'robots.txt' => 'robots/txt',
                'kontakty' => 'site/contacts',
                'search' => 'search',
                'send/<action:(order)>' => 'send/<action>',

                'catalog/<alias:[\wd-]+>' => 'product/show',

                'maker/<alias:[\wd-]+>' => 'maker/show',

                'brand-<alias:[\wd-]+>' => 'brand/show',

                '<alias:[\wd-]+>' => 'site/page',

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/brand-<brand:[\wd-]+>/<page:\d+>',
                    'route' => 'brand-catalog/products-with-brand',
                    'defaults' => ['page' => 0]
                ],

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/<subcategory:[\wd-]+>/brand-<brand:[\wd-]+>/<page:\d+>',
                    'route' => 'brand-catalog/products-with-brand-subcategory',
                    'defaults' => ['page' => 0]
                ],

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/<page:\d+>',
                    'route' => 'catalog/show',
                    'defaults' => ['page' => 0]
                ],

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/<subcategory:[\wd-]+>/<page:\d+>',
                    'route' => 'catalog/show-sub-category',
                    'defaults' => ['page' => 0]
                ],
            ],
        ],
        'view' => [
            'class' => View::class,
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => '\yii\helpers\Html',
                        'url' => '\yii\helpers\Url',
                        'stringHelper' => '\yii\helpers\StringHelper'
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
