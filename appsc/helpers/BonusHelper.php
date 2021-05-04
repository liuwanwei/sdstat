<?php
namespace appsc\helpers;

class BonusHelper {

    /**
     * 对存在加强属性的属性，返回形如 “基础值 - 加强值” 类型的描述字符串
     * 如果不存在加强属性，或加强值等于基础值，则返回基础值本身。
     *
     * @param [type] $model
     * @param [type] $baseAttr
     * @return void
     */
    public static function bonusRange($model, $baseAttr){
        $bonusAttr = $baseAttr . 'Bonus';
        if ($model->$bonusAttr != $model->$baseAttr) {
            return $model->$baseAttr . '-' . $model->$bonusAttr;
        }else{
            return $model->$baseAttr;
        }
    }
}

?>