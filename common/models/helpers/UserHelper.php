<?php
namespace common\models\helpers;

use common\models\User;
use Yii;

class UserHelper extends \yii\base\BaseObject{

    // 复用 yii2 初始化时创建的 user.password_reset_token 存储 access_token
    const AccessTokenField = "password_reset_token";

    public static function curUid(){
        return Yii::$app->user->identity->id;
    }

    /**
     * 根据用户名和密码创建用户
     *
     * @param string $username
     * @param string $password
     * @return User|null 成功时返回 User 对象，失败时返回 null，错误信息在 app.log 中查看。
     */
    public static function createUser(string $username, string $password = null){
        $helper = new static();
        return $helper->create($username, $password);
    }

    /**
     * 删除用户：创建用户的逆过程，删除创建时生成的数据
     *
     * @param integer $userId
     * @return void
     */
    public static function deleteUser(int $userId){
        $helper = new static();
        $helper->delete($userId);
    }

    /**
     * 创建管理用户
     *
     * @param string $username
     * @param string $password
     * @return \common\models\User|null 失败时返回 null，成功时返回 User 对象，如果用户已经存在，更新密码。
     */
    public function create($username, $password = null){
        if ($password == null) {
            // 生成 8 位随机密码
            $password = Yii::$app->security->generateRandomString(8);
        }

        $user = User::findOne(['username' => $username]);
        if ($user == null){
            $user = new User();
        }
        
        $user->username = $username;
        $user->setPassword($password);
        $user->email = $username . Yii::$app->params['emailDomain'];
        $user->generateAuthKey();
        $user->status = User::STATUS_ACTIVE;

        $ret = $user->save();
        if (! $ret) {
            Yii::error($user->getErrors());
            return null;
        }else{
            return $user;
        }
    }
    
    public function delete(int $userId){
        User::findOne($userId)->delete();
    }
}
?>