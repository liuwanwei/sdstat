<?php

namespace appsc\models;

use buddysoft\widget\controllers\NamedActiveRecord;
use PHPUnit\Util\Log\TAP;
use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property int $category 0 for unit, 1 for building
 * @property string $race P T Z
 * @property string $name
 * @property int $type 1Small 2Medium 3Large
 * @property int $force 1Ground 2Air
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
 * @property int $castRange 施法距离
 * @property int $detectRange 探测距离
 * @property int $groundDamageEffect 带爆炸式攻击
 * @property int $airDamageEffect 带震荡式攻击
 * @property string $createdAt
 * @property string $updatedAt
 */
class Unit extends NamedActiveRecord
{
    const CATEGORY_UNIT     = 0;
    const CATEGORY_BUILDING = 1;
    const CATEGORIES = [
        self::CATEGORY_UNIT => 'Units',
        self::CATEGORY_BUILDING => 'Buildings',
    ];

    const RACES = ['P' => 'P', 'T' => 'T', 'Z' => 'Z'];

    const TYPE_SMALL    = 1;
    const TYPE_MEDIUM   = 2;
    const TYPE_LARGE    = 3;
    const TYPES = [
        self::TYPE_SMALL => 'Small',
        self::TYPE_MEDIUM => 'Medium',
        self::TYPE_LARGE => 'Large',
    ];

    const FORCE_GROUND  = 1;
    const FORCE_AIR     = 2;
    const FORCES = [
        self::FORCE_GROUND => 'Ground',
        self::FORCE_AIR => 'Air',
    ];

    // groundDamageEffect and airDamageEffect values
    const DAMAGE_EFFECT_NORMAL      = 1;
    const DAMAGE_EFFECT_EXPLOSIVE   = 2;
    const DAMAGE_EFFECT_CONCUSSIVE   = 3;
    const DAMAGE_EFFECT_SPLASH      = 4;
    const DAMAGE_EFFECTS = [
        self::DAMAGE_EFFECT_NORMAL => 'Normal',
        self::DAMAGE_EFFECT_EXPLOSIVE => 'Explosive',
        self::DAMAGE_EFFECT_CONCUSSIVE => 'Concussive',
        self::DAMAGE_EFFECT_SPLASH => 'Splash',
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
            [['category', 'race', 'name'], 'required'],
            [['type', 'force', 'mineCost', 'gasCost', 'timeCost', 'hp', 'shield', 'armor', 'sight', 'sightBonus', 'castRange', 'detectRange', 'groundDamageEffect', 'airDamageEffect'], 'integer'],
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
            'category' => TApp('Category'),
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
            'castRange' => TApp('Cast Range'),
            'detectRange' => TApp('Detect Range'),

            'groundDamageEffect' => TApp('Ground Damage Deffect'),
            'airDamageEffect' => TApp('Air Damage Deffect'),

            'createdAt' => TApp('Created At'),
            'updatedAt' => TApp('Updated At'),
        ];
    }

    public function getDamages(){
        return $this->hasMany(Damage::class, ['unitId' => 'id'])->orderBy(['scope' => SORT_ASC]);
    }

    public function buildResCost(){
        $mine = '/img/30px-Scr-minerals.png';
        $gas = '/img/30px-Scr-gas-t.png';
        $cost = "<img src=$mine width=20 height=20> {$this->mineCost}";
        if ($this->gasCost) {
            $cost .= " <img src=$gas width=20 height=20> {$this->gasCost}"; 
        }
        return $cost;
    }

    public function buildTimeCost(){
        $time = '/img/DurationIcon.gif';
        return "<img src=$time width=20 height=20> $this->timeCost";
    }
}
