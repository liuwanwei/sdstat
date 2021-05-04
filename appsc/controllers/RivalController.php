<?php

namespace appsc\controllers;

use appsc\models\RivalSearch;
use Yii;

class RivalController extends \yii\web\Controller{

  public function actionIndex(){
    $searchModel = new RivalSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index',[
      'dataProvider' => $dataProvider,
      'searchModel' => $searchModel,
    ]);
  }
}

?>