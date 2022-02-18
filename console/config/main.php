<?php

use yii\console\controllers\MigrateController;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class' => MigrateController::class,
            'migrationNamespaces' => [
                // TODO: 记到文档里：根目录下的 migrations 不带 namespace，都会首先读取，不用在这里设置                
                // 'app/migrations',
                'appsc\migrations',

                // TODO: 记到文档里：要想禁用不带 namespace 的，可以设置这个属性
                // migrationPath 的文档里写的很清楚：
                // Migration classes located at this path should be declared without a namespace.
                // 'migrationPath' => null
                
                // 所以加载顺序，首先从 migrationPath 中加载不带名字空间的 migrations，然后再去寻找名字空间里的。                
                // 证据在：BaseMigrationController::actionUp(){}
                //      $migrations = $this->getNewMigrations();
                // }
                // 在 getNewMigrations() 里可以看到加载顺序。
            ],
        ]
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
