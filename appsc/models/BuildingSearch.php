<?php

namespace appsc\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use appsc\models\Building;

/**
 * BuildingSearch represents the model behind the search form of `appsc\models\Building`.
 */
class BuildingSearch extends Building
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'mineCost', 'gasCost', 'timeCost', 'hp', 'shield', 'armor'], 'integer'],
            [['race', 'name', 'createdAt', 'updatedAt'], 'safe'],
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
        $query = Building::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'mineCost' => $this->mineCost,
            'gasCost' => $this->gasCost,
            'timeCost' => $this->timeCost,
            'hp' => $this->hp,
            'shield' => $this->shield,
            'armor' => $this->armor,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'race', $this->race])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
