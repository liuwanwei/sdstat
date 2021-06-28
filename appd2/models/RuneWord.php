<?php

namespace appd2\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "rune_word".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $cnName 中文名
 * @property string|null $equipments 所需
 * @property string|null $category 大类
 * @property string|null $runes 符文序号列表
 * @property int|null $slots 凹槽个数
 * @property int|null $maxRune 最大符文序号
 * @property int|null $level 角色需求等级
 * @property string|null $version 游戏版本
 * @property string|null $desc 描述信息，自己维护
 * @property string|null $html 抓取来的面板信息
 */
class RuneWord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rune_word';
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
            [['slots', 'maxRune', 'level'], 'integer'],
            [['desc', 'html'], 'string'],
            [['name', 'cnName', 'equipments'], 'string', 'max' => 64],
            [['category', 'version'], 'string', 'max' => 16],
            [['runes'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Rune Word Name'),
            'cnName' => Yii::t('app', 'Cn Name'),
            'equipments' => Yii::t('app', 'Equipments'),
            'category' => Yii::t('app', 'Category'),
            'runes' => Yii::t('app', 'Runes'),
            'slots' => Yii::t('app', 'Slots'),
            'maxRune' => Yii::t('app', 'Max Rune'),
            'level' => Yii::t('app', 'Level'),
            'version' => Yii::t('app', 'Version'),
            'desc' => Yii::t('app', 'Desc'),
            'html' => Yii::t('app', 'Html'),
        ];
    }

    public function getBetterName(array $marks){
        $tags = [];
        // $runes = implode(' · ', explode('/', $this->runes));
        $runes = explode('/', $this->runes);
        foreach($runes as $index) {
            $mark = $marks[$index] ?? false;
            $tags[] = Html::tag('span', $index, ['style' => $mark ? 'text-font: bold;' : 'color: darkgrey;']);
        }

        return implode('<span style="color:darkgrey;"> · </span>', $tags);
    }

    /**
     * 获取所需符文和个数
     *
     * @return array []
     * 
     * 返回数据格式：
     * [
     *      'rune.index' => 'count', // 符文序号和所需数量（经检查，只有下列符文之语需要两个相同的符文：Bone，Sanctuary，Phoenix，Infinity，Last Wish）
     * ]
     */
    public function getRuneRequirement(){
        $result = [];
        $indexes = explode('/', $this->runes);
        foreach ($indexes as $key) {
            if (isset($result[$key])) {
                // 最多出现两次相同的符文，所以简单处理
                $result[$key] = 2;
            }else{
                $result[$key] = 1;
            }
        }

        return $result;
    }
}
