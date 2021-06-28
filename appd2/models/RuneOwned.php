<?php

namespace appd2\models;

use Yii;

/**
 * This is the model class for table "rune_owned".
 *
 * @property int $id
 * @property int|null $userId user.id
 * @property int|null $runeId rune.id
 * @property int|null $count 拥有个数
 */
class RuneOwned extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rune_owned';
    }

    // public function formName(){
    //     return '';
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'runeId', 'count'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'runeId' => Yii::t('app', 'Rune ID'),
            'count' => Yii::t('app', 'Count'),
        ];
    }

    public function getRune(){
        return $this->hasOne(Rune::class, ['id' => 'runeId']);
    }
}
