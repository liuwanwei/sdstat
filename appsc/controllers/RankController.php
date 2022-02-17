<?php

namespace appsc\controllers;

use appsc\models\UnitSearch;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class RankController extends Controller{

    public function actionSpeed(){        
        $searchModel = new UnitSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        
        $query = $dataProvider->query;

        $data = $this->_checkGetData($query);

        return $this->render('speed', [
            'searchModel' => $searchModel,
            'data' => $data,       
        ]);
    }

    private function _checkGetData($query){
        $cache = Yii::$app->cache;
        if ($cache == null) {
            return $this->_fetchData($query);
        }

        $data = $cache->getOrSet($this->_getKey(), function($cache) use ($query){
            return $this->_fetchData($query);
        });

        return $data;
    }

    private function _getKey(){
        $request = Yii::$app->request;
        $race = $request->get('race');
        $force = $request->get('force');
        $mode = $request->get('mode');

        $key = "{$race}-{$force}-{$mode}";
        return $key;
    }

    private function _fetchData(ActiveQuery $query){
        $mode = \Yii::$app->request->get('mode');
        if ($mode == null || $mode == '0') {
            $sortColumn = 'speed';
        }else{
            $sortColumn = 'speedBonus';
        }
        $selects = 'name, speed, speedBonus';

        $query->select($selects)
            ->andWhere('speed IS NOT NULL')
            ->orderBy([$sortColumn => SORT_DESC]);
        $models = $query->asArray()->all();

        $names = Trans(ArrayHelper::getColumn($models, 'name'));
        $baseValues = ArrayHelper::getColumn($models, 'speed');
        $bonusValues = ArrayHelper::getColumn($models, 'speedBonus');
        $differences = [];
        $count = count($baseValues);
        for ($i=0; $i < $count; $i++) {
            if ($bonusValues[$i] == $baseValues[$i]) {
                $differences[] = null;
            }else{
                $differences[] = sprintf("%.3f", $bonusValues[$i] - $baseValues[$i]);   
            }            
        }

        return [
            'names' => json_encode($names),
            'baseValues' => json_encode($baseValues),
            'bonusValues' => json_encode($differences),
        ];
    }
}

?>