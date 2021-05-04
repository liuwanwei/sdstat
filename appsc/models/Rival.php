<?php
namespace appsc\models;


class Rival extends \yii\base\Model{
  /**
   * 输入属性
   */
  public $attackerId;
  public $defenderId;
  public $damageLevel;
  public $defenseLevel;
  public $shieldLevel;

  /** 
   * 输出属性
   */ 
  public $damage = 0;
  public $baseDamage = 0;
  public $typeFactor = 0;
  public $typeName = '';  
  public $shieldDamage = 0;

  /**
   * 进攻单位
   * @var app\models\Unit
   */
  private $_attacker;

  /**
   * 防守单位
   * @var app\models\Unit
   */
  private $_defender;

  public function attributeLabels()
  {
    return [
      'baseDamage' => 'Initial Damage',
      'damage' => 'Final Damage',
    ];
  }


  public function __construct(int $attackerId, int $defenderId, int $damageL, int $defenseL, int $shieldL)
  {
    $this->attackerId = $attackerId;
    $this->defenderId = $defenderId;
    $this->damageLevel = $damageL;
    $this->defenseLevel = $defenseL;
    $this->shieldLevel = $shieldL;

    $this->_attacker = Unit::findOne($this->attackerId);
    $this->_defender = Unit::findOne($this->defenderId);
  }

  public function description()
  {
    return @"{$this->_attacker->name} VS {$this->_defender->name}";
  }

  public function getAttacker(){
    return $this->_attacker;
  }

  public function getDefender(){
    return $this->_defender;
  }

  /**
   * 获取攻防双方之间的伤害类型因子
   *
   * @return float
   */
  private function _typeFactor(): float{
    // 默认普通攻击,全伤害,系数为 1
    $typeFactor = 1;
    $type = $this->_defender->type;

    if ($this->_attacker->explosive) {      
      $EXP = 'Explosive';

      // 爆炸式攻击对大单位造成全伤害
      if ($type == TYPE_MEDIUM){
        $typeFactor = 0.75;
        $typeName = $EXP;
      }else if ($type == TYPE_SMALL){
        $typeFactor = 0.5;
        $typeName = $EXP;
      }
    }else if ($this->_attacker->concussive){
      $CON = 'Concussive';
      // 震荡式攻击对大单位伤害会削弱
      if ($type == TYPE_LARGE) {
        $typeFactor = 0.25;
        $typeName = $CON;
      }else if ($type == TYPE_MEDIUM){
        $typeFactor = 0.5;
        $typeName = $CON;
      }
    }

    if ($typeFactor != 1) {
      $this->typeFactor = $typeFactor;
      $this->typeName = $typeName;
    }
    
    return $typeFactor;
  }


  private function _baseDamageValue($defense){
    if ($this->_defender->isGroundForce()) {
      $damage = $this->_attacker->damageToGround($this->damageLevel, $defense);
    }else{
      $damage = $this->_attacker->damageToAir($this->damageLevel, $defense);
    }

    $this->baseDamage = $damage;

    return $damage;
  }

  /**
   * 开始进攻,计算结果
   *
   * @return void
   */
  public function attack(){
    // 计算对生命值的伤害
    $defense = $this->_defender->realDefense($this->defenseLevel);
    $damage = $this->_baseDamageValue($defense);
    if ($damage <= 0) {
      return;
    }

    // 震荡式攻击和爆炸式攻击有削弱
    $damage = $damage * $this->_typeFactor() + 0.5;
    $damage = intval($damage);
    $this->damage = $damage;

    // 对神族时计算对护盾的伤害
    if ($this->_defender->race == RACE_P) {
      // 影响因子只有护盾等级
      $damage = $this->_baseDamageValue($this->shieldLevel);
      $this->shieldDamage = $damage;
    }
  }
}

?>