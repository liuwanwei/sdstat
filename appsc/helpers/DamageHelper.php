<?php
namespace appsc\helpers;

use appsc\models\Damage;

// 尚未使用
class DamageHelper{

    public static function fillEffects(){

    }

    public static function updateCooldown(?Damage $damage, $base, $bonus) {
        if ($damage) {
            $damage->updateCooldown($base, $bonus);
        }
    }

    public static function updateDps(?Damage $damage, $base, $bonus){
        if ($damage){
            $damage->updateDps($base, $bonus);
        }
    }
}

?>