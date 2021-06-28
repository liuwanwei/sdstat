<?php
namespace common\assets;

class EuiAsset extends \yii\web\AssetBundle{

    /**
     * 默认引入到 \yii\web\View::POS_HEAD
     *
     * @var array
     */
    public $css = [
        'https://unpkg.com/element-ui/lib/theme-chalk/index.css'
    ];

    /**
     * 默认引入到 \yii\web\View::POS_END
     *
     * @var array
     */
    public $js = [
        'https://unpkg.com/element-ui/lib/index.js'
    ];
}
?>