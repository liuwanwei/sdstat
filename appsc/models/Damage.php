<?php

namespace appsc\models;

use buddysoft\widget\controllers\NamedActiveRecord;
use Yii;

/**
 * This is the model class for table "damage".
 *
 * @property int $id
 * @property int $unitId
 * @property int $scope 作用范围，0对地 1对空
 * @property int|null $base 基础值
 * @property int|null $stride 升级增加值
 * @property int|null $times 打击次数
 * @property int|null $explosive 爆炸伤害
 * @property int|null $concussive 震荡伤害
 * @property int|null $splash 溅射伤害
 * @property int|null $range 攻击距离
 * @property int|null $rangeBonus 范围升级后值
 * @property float|null $cooldown 冷却时间
 * @property float|null $cooldownBonus 冷却时间升级后值
 * @property float|null $dps 每秒造成伤害
 * @property float|null $dpsBonus
 */
class Damage extends NamedActiveRecord
{
    const SCOPE_GROUND = 0; 
    const SCOPE_AIR = 1; 
    const SCOPES = [ 
        self::SCOPE_GROUND => '对地', 
        self::SCOPE_AIR => '对空', 
    ]; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'damage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unitId', 'scope'], 'required'],
            [['unitId', 'scope', 'base', 'stride', 'times', 'explosive', 'concussive', 'splash', 'range', 'rangeBonus'], 'integer'],
            [['cooldown', 'cooldownBonus', 'dps', 'dpsBonus'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unitId' => 'Unit ID',
            'scope' => TApp('Scope'),
            'base' => TApp('Base Damage'),
            'stride' => TApp('Stride'),
            'times' => TApp('Times'),
            'explosive' => TApp('Explosive'),
            'concussive' => TApp('Concussive'),
            'splash' => TApp('Splash'),
            'range' => TApp('Range'),
            'rangeBonus' => 'Range Bonus',
            'cooldown' => TApp('Cooldown'),
            'cooldownBonus' => 'Cooldown Bonus',
            'dps' => TApp('Dps'),
            'dpsBonus' => 'Dps Bonus',
        ];
    }

    public function getUnit(){
        return $this->hasOne(Unit::class, ['id' => 'unitId']);
    }

    public function updateCooldown($base, $bonus){
        $this->cooldown = $base;
        $this->cooldownBonus = $bonus;

        // $this->save();
    }

    public function updateDps($base, $bonus){
        $this->dps = $base;
        $this->dpsBonus = $bonus;
        // $this->save();
    }
}
