<?php
require __DIR__ . '/constants.php';

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-sc',
    'name' => '星际基本属性',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'appsc\controllers',
    'defaultRoute' => 'unit/index',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-appsc',
        ],
        'user' => [
            'identityClass' => 'appsc\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-appsc', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the appsc
            'name' => 'advanced-appsc',
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
            'rules' => [
            ],
        ],
        'formatter' => [
            'nullDisplay' => '',
        ]
    ],
    'params' => $params,
];
