<?php

namespace appsc\models;

use Yii;

/**
 * This is the model class for table "bonus".
 *
 * @property int $id
 * @property int $unitId 作用对象
 * @property int $type 增强属性类型
 * @property int $scope 作用范围
 * @property float $value 增加数值
 * @property string|null $image 图片信息
 * @property string|null $name 升级名字
 * @property string|null $building 升级建筑
 * @property int|null $mineCost 水晶耗费
 * @property int|null $gasCost 气体耗费
 * @property int|null $timeCost 升级时长
 * @property string $createdAt
 * @property string $updatedAt
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bonus';
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
            [['unitId', 'type', 'value'], 'required'],
            [['unitId', 'type', 'scope', 'mineCost', 'gasCost', 'timeCost'], 'integer'],
            [['value'], 'number'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name', 'image', 'building'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Bonus Name'),
            'unitId' => Yii::t('app', 'Unit ID'),
            'type' => Yii::t('app', 'Bonus Type'),
            'scope' => TApp('Scope'),
            'value' => Yii::t('app', 'Bonus Value'),
            'image' => Yii::t('app', 'Image'),
            'building' => Yii::t('app', 'Building'),
            'mineCost' => Yii::t('app', 'Mine Cost'),
            'gasCost' => Yii::t('app', 'Gas Cost'),
            'timeCost' => Yii::t('app', 'Time Cost'),

            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * 将选项的 value 经过 i18n 转换成对应语言
     * 
     * @param array $options 选项
     * 
     * @return array
     */
    public static function translate(array $options)
    {
        $trans = [];
        foreach ($options as $key => $value) {
            $trans[$key] = TApp($value);
        }

        return $trans;
    }

    public static function addNullOption(array & $options, string $nullOptionName = null){
        if ($nullOptionName == null) {
            $nullOptionName = 'All Options';
        }
        $options = [null => TApp($nullOptionName)] + $options;
    }

    /**
     * 生成根据当前语言翻译后的选项
     * 
     * @param bool $needNullOptions 是否需要什么都不选的选项
     * 
     * @return array
     */
    public static function typeOptions(bool $needNullOption = false){
        $options = self::translate(BONUS_TYPES);        
        if ($needNullOption) {
            self::addNullOption($options);
        }
        return $options;
    }

    public static function scopeOptions(bool $needNullOption = false){
        $options = self::translate(BONUS_SCOPES);
        if ($needNullOption) {
            self::addNullOption($options);
        }

        return $options;
    }
    
}
