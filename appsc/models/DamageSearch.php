<?php

namespace appsc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use appsc\models\Damage;

/**
 * DamageSearch represents the model behind the search form of `appsc\models\Damage`.
 */
class DamageSearch extends Damage
{
    public $unitName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'unitId', 'scope', 'base', 'stride', 'times', 'explosive', 'concussive', 'splash', 'range', 'rangeBonus'], 'integer'],
            [['cooldown', 'cooldownBonus', 'dps', 'dpsBonus'], 'number'],
            [['unitName'], 'safe'],
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
        $query = Damage::find();

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
            'unitId' => $this->unitId,
            'scope' => $this->scope,
            'base' => $this->base,
            'stride' => $this->stride,
            'times' => $this->times,
            'explosive' => $this->explosive,
            'concussive' => $this->concussive,
            'splash' => $this->splash,
            'range' => $this->range,
            'rangeBonus' => $this->rangeBonus,
            'cooldown' => $this->cooldown,
            'cooldownBonus' => $this->cooldownBonus,
            'dps' => $this->dps,
            'dpsBonus' => $this->dpsBonus,
        ]);

        $query->andFilterWhere(['like', 'unit.name', $this->unitName]);

        return $dataProvider;
    }
}
