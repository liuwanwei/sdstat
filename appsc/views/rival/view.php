<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="rival-view">
  <h1><?= Html::encode($model->description()) ?></h1>

  <p></p>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'damage',
      'shieldDamage',
    ]
  ])?>
</div>