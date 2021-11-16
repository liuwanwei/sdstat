<?php

namespace appsc\helpers;

use Yii;
use yii\helpers\Html;

class MenuHelper{

    public static function getMenus(){
        $isGuest = Yii::$app->user->isGuest;

        $menus = [
            ['label' => TApp('Units'), 'url' => ['/unit/index']],
            ['label' => TApp('Speed'), 'url' => ['/rank/speed']],           
        ];
        
        if (! $isGuest) {
            $menus[] = ['label' => TApp('Import'), 'url' => ['/unit/import']];
            $menus[] = ['label' => TApp('Backups'), 'url' => ['/db-manager']];
        }
            
        // ['label' => TApp('Damage'), 'url' => ['/damage/index']],            
        // ['label' => TApp('Rivals'), 'url' => ['/rival/index']],
        // ['label' => TApp('Buildings'), 'url' => ['/building/index']],
        
        if ($isGuest) {
            $menus[] = ['label' => T('Admin'), 'url' => ['/site/login']];
        }else{
            $menus[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
        }

        return $menus;
    }
}

?>