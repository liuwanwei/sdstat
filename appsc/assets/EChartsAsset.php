<?php
namespace app\assets;

use yii\web\AssetBundle;

class EChartsAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $js = [
        'js/echarts.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}

?>