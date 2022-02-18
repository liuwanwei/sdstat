<?php

namespace appsc\models;

use Yii;

/**
 * This is the model class for table "building".
 *
 * @property int $id
 * @property string $race P T Z
 * @property string $name
 * @property int|null $mineCost
 * @property int|null $gasCost
 * @property int|null $timeCost
 * @property int|null $hp 生命值
 * @property int|null $shield 护盾值
 * @property int|null $armor 初始防御值
 * @property string $energy
 * @property string $createdAt
 * @property string $updatedAt
 */
class Building extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'building';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['race', 'name'], 'required'],
            [['mineCost', 'gasCost', 'timeCost', 'hp', 'shield', 'armor'], 'integer'],
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
            'id' => Yii::t('app', 'ID'),
            'race' => Yii::t('app', 'Race'),
            'name' => Yii::t('app', 'Name'),
            'mineCost' => Yii::t('app', 'Mine Cost'),
            'gasCost' => Yii::t('app', 'Gas Cost'),
            'timeCost' => Yii::t('app', 'Time Cost'),
            'hp' => Yii::t('app', 'Hp'),
            'shield' => Yii::t('app', 'Shield'),
            'armor' => Yii::t('app', 'Armor'),
            'energy' => Yii::t('app', 'Energy'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }
}
