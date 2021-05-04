<?php

/**
 * FIXME: 生成根据 race 查询 unit id 数组的 ajax 接口,并在 race/id 之间建立依赖关系
 */

use appsc\helpers\DepDropHelper;
use appsc\helpers\DropDownHelper;
use appsc\models\Unit;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

function levelsForAttribute($attr){
  $levels = [
    0 => '无'.$attr,
    1 => '1'.$attr,
    2 => '2'.$attr,
    3 => '3'.$attr,
  ];

  return $levels;
}

// $races = Unit::RACES;
$races = ArrayHelper::merge([null => '请选择'], Unit::RACES);

// Initialize attacker options
$attackers = [];
if (isset($model->attackerRace)) {
  $units = Unit::findAll(['race' => $model->attackerRace]);
  $attackers = DropDownHelper::makeItems($units, 'Select...');
}

// Initialize defender options
$defenders = [];
if (isset($model->defenderRace)) {
  $units = Unit::findAll(['race' => $model->defenderRace]);
  $defenders = DropDownHelper::makeItems($units, 'Select...');
}
?>

<div class="rival-search">
  <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'id' => 'rival-search-form',
    'type' => ActiveForm::TYPE_INLINE,
  ]); ?>

  <div class="form-group">
    <label class='col-form-label has-star'>进攻方: </label>
  </div>

  <!-- 构建相互依赖的两个控件，实现对不同种族兵种的选择 -->
  <?= $form->field($model, 'attackerRace')->dropDownList($races, ['id' => 'attacker-race']) ?>
  <?= $form->field($model, 'attackerId')->widget(DepDrop::class, [
    'options' => ['id' => 'attacker-id'],
    'data' => $attackers,
    'pluginOptions' => [
      'depends' => ['attacker-race'],
      'placeholder' => 'Select...',
      'url' => Url::to(['/unit/search']),
    ]
  ]) ?>
  <?= $form->field($model, 'damageLevel')->dropDownList(levelsForAttribute('攻')) ?>

  <div class="form-group">
    <label class='col-form-label'>防御方: </label>
  </div>  

  <!-- 构建相互依赖的两个控件，实现对不同种族兵种的选择 -->
  <?= $form->field($model, 'defenderRace')->dropDownList($races, ['id' => 'defender-race']) ?>
  <?= $form->field($model, 'defenderId')->widget(DepDrop::class, [
    'options' => ['id' => 'defender-id'],
    'data' => $defenders,
    'pluginOptions' => [
      'depends' => ['defender-race'],
      'placeholder' => 'Select...',
      'url' => Url::to(['/unit/search']),
    ]
  ]) ?>
  <?= $form->field($model, 'defenseLevel')->dropDownList(levelsForAttribute('防')) ?>
  <?= $form->field($model, 'shieldLevel')->dropDownList(levelsForAttribute('盾')) ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    <!-- <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?> -->
  </div>

  <?php ActiveForm::end()?>
</div>