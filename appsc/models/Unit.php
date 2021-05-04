<?php

namespace appsc\models;

use buddysoft\widget\controllers\NamedActiveRecord;
use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string $race P T Z
 * @property string $name
 * @property int $type 0Small 1Medium 2Large
 * @property int $force 0Ground 1Air
 * @property int|null $mineCost
 * @property int|null $gasCost
 * @property int|null $timeCost
 * @property float|null $unitCost
 * @property int|null $hp 生命值
 * @property int|null $shield 护盾值
 * @property int|null $armor 初始防御值
 * @property string|null $energy 能量
 * @property int|null $sight 视野值
 * @property int|null $sightBonus 视野加强后值
 * @property float|null $speed 移动速度值
 * @property float|null $speedBonus 移动速度加强后值
 * @property string $createdAt
 * @property string $updatedAt
 */
class Unit extends NamedActiveRecord
{
    const RACES = ['P' => 'P', 'T' => 'T', 'Z' => 'Z'];

    const TYPE_SMALL    = 0;
    const TYPE_MEDIUM   = 1;
    const TYPE_LARGE    = 2;
    const TYPES = [
        self::TYPE_SMALL => 'Small',
        self::TYPE_MEDIUM => 'Medium',
        self::TYPE_LARGE => 'Large',
    ];

    const FORCE_GROUND  = 0;
    const FORCE_AIR     = 1;
    const FORCES = [
        self::FORCE_GROUND => 'Ground',
        self::FORCE_AIR => 'Air',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit';
    }

    public function formName(){
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['race', 'name', 'type', 'force'], 'required'],
            [['type', 'force', 'mineCost', 'gasCost', 'timeCost', 'hp', 'shield', 'armor', 'sight', 'sightBonus'], 'integer'],
            [['unitCost', 'speed', 'speedBonus'], 'number'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['race'], 'string', 'max' => 255],
            [['name', 'energy'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'race' => TApp('Race'),
            'name' => TApp('Name'),
            'type' => TApp('Type'),
            'force' => TApp('Force'),
            'mineCost' => TApp('Mine Cost'),
            'gasCost' => TApp('Gas Cost'),
            'timeCost' => TApp('Time Cost'),
            'unitCost' => TApp('Unit Cost'),
            'hp' => TApp('Hp'),
            'shield' => TApp('Shield'),
            'armor' => TApp('Armor'),
            'energy' => TApp('Energy'),
            'sight' => TApp('Sight'),
            'sightBonus' => TApp('Sight Bonus'),
            'speed' => TApp('Speed'),
            'speedBonus' => TApp('Speed Bonus'),

            'createdAt' => TApp('Created At'),
            'updatedAt' => TApp('Updated At'),
        ];
    }

    public function getDamages(){
        return $this->hasMany(Damage::class, ['unitId' => 'id'])->orderBy(['scope' => SORT_ASC]);
    }
}
