<?php

namespace appd2\models;

use Yii;

/**
 * This is the model class for table "rune".
 *
 * @property int $id
 * @property int|null $index
 * @property string|null $name
 * @property string|null $cnName
 * @property int|null $level
 * @property string|null $dropRate
 * @property string|null $boss
 * @property string|null $difficulty
 * @property string|null $img
 * @property string|null $formula 合成公式
 */
class Rune extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rune';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['index', 'level'], 'integer'],
            [['img', 'formula'], 'string'],
            [['name', 'cnName', 'dropRate', 'boss', 'difficulty'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'index' => Yii::t('app', 'Index'),
            'name' => Yii::t('app', 'Name'),
            'cnName' => Yii::t('app', 'Cn Name'),
            'level' => Yii::t('app', 'Level'),
            'dropRate' => Yii::t('app', 'Drop Rate'),
            'boss' => Yii::t('app', 'Boss'),
            'difficulty' => Yii::t('app', 'Difficulty'),
            'img' => Yii::t('app', 'Img'),
            'formula' => Yii::t('app', 'Formula'),
        ];
    }

    public function getCombinedName(){
        return "{$this->index} / " . $this->name . ' / ' . $this->cnName;
    }
}
