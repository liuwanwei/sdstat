<?php

namespace appd2\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RuneSearch represents the model behind the search form of `app\models\Rune`.
 */
class RuneSearch extends Rune
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'index', 'level'], 'integer'],
            [['name', 'cnName', 'dropRate', 'boss', 'difficulty', 'img', 'formula'], 'safe'],
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
        $query = Rune::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setPagination(false);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'index' => $this->index,
            'level' => $this->level,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cnName', $this->cnName])
            ->andFilterWhere(['like', 'dropRate', $this->dropRate])
            ->andFilterWhere(['like', 'boss', $this->boss])
            ->andFilterWhere(['like', 'difficulty', $this->difficulty])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'formula', $this->formula]);

        return $dataProvider;
    }
}
