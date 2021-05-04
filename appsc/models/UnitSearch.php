<?php

namespace appsc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UnitSearch represents the model behind the search form of `app\models\Unit`.
 */
class UnitSearch extends Unit
{
    // 查询速度时，查询默认速度还是暴走后的速度，0基础，1暴走
    public $mode;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'force', 'mineCost', 'gasCost', 'timeCost', 'unitCost', 'hp', 'shield', 'armor', 'sight', 'sightBonus'], 'integer'],
            [['race', 'name', 'energy', 'createdAt', 'updatedAt'], 'safe'],
            [['speed', 'speedBonus'], 'number'],
            [['mode'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Unit::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'force' => $this->force,
            'mineCost' => $this->mineCost,
            'gasCost' => $this->gasCost,
            'timeCost' => $this->timeCost,
            'unitCost' => $this->unitCost,
            'hp' => $this->hp,
            'shield' => $this->shield,
            'armor' => $this->armor,
            'sight' => $this->sight,
            'sightBonus' => $this->sightBonus,
            'speed' => $this->speed,
            'speedBonus' => $this->speedBonus,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'race', $this->race])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'energy', $this->energy]);

        return $dataProvider;
    }
}
