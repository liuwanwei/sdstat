<?php

namespace appsc\models;

use Yii;

/**
 * This is the model class for table "building".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $race P/T/Z
 * @property int|null $mineCost
 * @property int|null $gasCost
 * @property int|null $timeCost
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
            [['mineCost', 'gasCost', 'timeCost'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name', 'race'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'race' => 'Race',
            'mineCost' => 'Mine Cost',
            'gasCost' => 'Gas Cost',
            'timeCost' => 'Time Cost',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }
}
