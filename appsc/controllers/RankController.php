<?php

namespace appsc\controllers;

use appsc\models\Unit;
use app\models\UnitSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class RankController extends Controller{

    public function actionSpeed(){
        // $models = Unit::find()->select('name, speedBonus')->orderBy(['speedBonus' => SORT_DESC])->asArray()->all();
        $searchModel = new UnitSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $query = $dataProvider->query;

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

        return $this->render('speed', [
            'searchModel' => $searchModel,
            'names' => json_encode($names),
            'baseValues' => json_encode($baseValues),
            'bonusValues' => json_encode($differences),
        ]);
    }
}

?>