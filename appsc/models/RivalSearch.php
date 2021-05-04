<?php

namespace appsc\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class RivalSearch extends Rival{

  // 增加两个属性:选族
  public $attackerRace;
  public $defenderRace;

  public function __construct()
  {
    // 为避免调用 Rival::__construct()，这里定义个空函数
  }

  public function formName()
  {
    return ''; 
  }

  public function rules(){
    return [
      [['attackerId', 'defenderId'], 'integer'],
      [['attackerRace', 'defenderRace', 'damageLevel', 'defenseLevel', 'shieldLevel'], 'integer'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'attackerId' => '进攻方',
      'defenderId' => '防守方',
      'damageLevel' => '攻击',
      'defenseLevel' => '防御',
      'shieldLevel' => '护盾',
    ];
  }

  public function search($params){
    $error = [];

    $this->load($params);
    if (empty($this->attackerId)) {
      $error[] = '请选择进攻方';
    }else if (strlen($this->defenderRace) <= 0) {
      $error[] = '请选择对手';
    }

    $models = [];
    if (!empty($error)) {
      Yii::$app->session->setFlash('info', join(';', $error));
    }else{
      if (empty($this->defenderId)) {
        $defenders = Unit::findAll(['race' => $this->defenderRace]);
        $defenderIds = ArrayHelper::getColumn($defenders, 'id');
      }else{
        $defenderIds = [$this->defenderId];
      }

      foreach ($defenderIds as  $id) {
        $rival = new Rival($this->attackerId, $id, $this->damageLevel, $this->defenseLevel, $this->shieldLevel);
        $rival->attack();
        $models[] = $rival;
      }      
    }

    $dataProvider = new ArrayDataProvider([
      'key' => 'attackerId',
      'allModels' => $models,
      'sort' => [
        'attributes' => ['defenderId'],
      ]
    ]);

    return $dataProvider;
  }
}

?>