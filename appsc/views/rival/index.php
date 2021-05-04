<?php

use yii\helpers\Html;

$models = $dataProvider->allModels;
?>

<p>
  <?= $this->render('_search', ['model' => $searchModel]); ?>
</p>

<p>
</p>

<?php
$total = count($models);
echo $this->render('grid', [
  'dataProvider' => $dataProvider,
  'searchModel' => $searchModel,
]);

// 统一使用 grid 方式展示，不论有几个结果
// if (empty($searchModel->defenderId)) {
//   // 没有选择特定单位时，显示所有对抗
//   echo $this->render('grid', ['dataProvider' => $dataProvider]); 
// }else{
//   echo $this->render('view', ['model' => $models[0]]); 
// }
?>