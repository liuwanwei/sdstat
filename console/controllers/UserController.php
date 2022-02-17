<?php
namespace console\controllers;

use common\models\helpers\UserHelper;
use yii\console\Controller;

class UserController extends Controller{

    /**
     * 注册后台登录用户
     * Usage: ./yii user/register admin 123456
     *
     * @param string $username
     * @param string $password
     * @return string
     */
    public function actionRegister($username, $password){
        $user = UserHelper::createUser($username, $password);
        if(! $user) {
            echo "创建用户失败";
        }else{
            echo "创建用户成功";
        }
    }
}
?>