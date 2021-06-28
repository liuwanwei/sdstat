<?php

namespace appd2\models;

use appd2\helpers\RuneHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RuneOwnedSearch represents the model behind the search form of `app\models\RuneOwned`.
 */
class RuneOwnedSearch extends RuneOwned
{
    public $moreThanOne;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'runeId', 'count'], 'integer'],
            ['moreThanOne', 'safe']
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
        $query = RuneOwned::find();

        if (\Yii::$app->user->isGuest) {
            // FIXME: 测试时使用，未登录时可以测试
            $userId = 0;
            RuneHelper::createDefaults($userId);
            $this->userId = $userId;
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if (! empty($this->moreThanOne)) {
            $query->andFilterWhere(['>', 'count', 0]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userId' => $this->userId,
            'runeId' => $this->runeId,
            'count' => $this->count,
        ]);        

        return $dataProvider;
    }
}
