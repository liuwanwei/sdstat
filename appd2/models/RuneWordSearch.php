<?php

namespace appd2\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use appd2\helpers\RuneHelper;

/**
 * RuneWordSearch represents the model behind the search form of `app\models\RuneWord`.
 */
class RuneWordSearch extends RuneWord
{
    public $resultScope;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'slots', 'maxRune', 'level'], 'integer'],
            [['name', 'cnName', 'equipments', 'category', 'runes', 'version', 'desc', 'html', 'resultScope'], 'safe'],
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
        $query = RuneWord::find();

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
            'slots' => $this->slots,
            'maxRune' => $this->maxRune,
        ]);

        $query->andFilterWhere(['like', 'equipments', $this->equipments])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'runes', $this->runes])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'html', $this->html]);

        $query->andFilterWhere(['or', ['like', 'name', $this->name], ['like', 'cnName', $this->name]]);
        
        if (isset($this->level) && !empty($this->level)) {
            $query->andFilterWhere(['<=', 'level', $this->level]);
        }

        return $dataProvider;
    }

    /**
     * 搜索自身收集的符文可以打造的符文之语装备情况
     *
     * @param array $params
     * @return list [$allRuneWords, $matched, $count] 
     *              $allRuneWords, 是所有符文之语对象数组
     *              $matched, 跟第一个参数一一对应，数组元素为布尔型，代表是否可以打造
     *              $count, 能够打造的附文之语个数
     */
    public function searchOwned($params){
        // 获取匹配中装备、孔数的所有符文之语
        $dataProvider = $this->search($params);
        $runeWords = $dataProvider->query->all();

        $result = RuneHelper::searchByOwnedRunes($runeWords, $params['resultScope']??false);

        $arrayDataProvider = new ArrayDataProvider([
            'allModels' => $result['runeWords'],
            'key' => 'id',
            'pagination' => false,
        ]);

        return [$arrayDataProvider, $result['matches'], $result['count']];
    }
}
