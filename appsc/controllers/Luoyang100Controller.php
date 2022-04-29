<?php
/**
 * 为了备案 luoyang100.cn 域名,在这里做了个假的首页,通过 nginx 配置文件 luoyang100.conf 设定所有访问都重定向到 luoyang100/index
 */
namespace appsc\controllers;

class Luoyang100Controller extends \yii\web\Controller {

    public $layout = false;

    public function actionIndex(){
        return $this->render('index');
    }
}


?>
