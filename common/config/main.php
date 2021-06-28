<?php
/**
 * 封装 Yii::t('app', ...)
 *
 * @param string $name
 * @return string
 */
function TApp($name, $params = []){
    return \Yii::t('app', $name, $params);
}

function T($name, $params = []){
    return \Yii::t('app', $name, $params);
}

function Trans($options) {
    foreach ($options as $key => $value) {
        $options[$key] = TApp($value);
    }

    return $options;
}

return [
    'timeZone' => 'Asia/Shanghai',
    'language' => 'zh-CN',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
