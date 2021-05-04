<?php
namespace appsc\helpers;

use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class DropDownHelper extends BaseObject{

  public static function makeItems($models, $defaultOption, $idKey = 'id', $nameKey = 'name')
  {
    $options = ArrayHelper::map($models, $idKey, $nameKey);
    if (empty($defaultOption)) {
      return $options;      
    }else{
      return ArrayHelper::merge([null => $defaultOption], $options);
    }
  }
  

  /**
   * 通过 \yii\base\Model 对象，生成符合 DepDrop 显示的选项数组
   * 
   * 数组元素必须有两个属性：id 对应选择的结果，name 对应展示名字内容。
   *
   * @param array $models
   * @param string $idKey     结果字段在 Model 中的名字
   * @param string $nameKey   名字字段在 Model 中的名字
   * @return void
   */
  public static function makeDepDropQueryResult(array $models, $idKey = 'id', $nameKey = 'name')
  {
    $out = [];
    foreach ($models as $model) {
        $out[] = [ 'id' => $model->$idKey, 'name' => $model->$nameKey];
    }

    if (empty($out)) {
      return ['output' => '', 'selected' => ''];
    }else{
      return ['output' => $out, 'selected' => ''];
    }    
  }
}

?>