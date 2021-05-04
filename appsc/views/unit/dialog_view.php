<?php

use app\assets\BonusAsset;
use kartik\dialog\Dialog;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\models\Bonus;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
BonusAsset::register($this);
?>

<div class="unit-view">
  <p>
    <?= Html::button('Create Bonus (dialog)', [
      // 放置 url 地址, 在响应函数 on('click', function()) 中使用，加载对话框的内容
      'value' => Url::to(['bonus/create', 'unitId' => $model->id]),
      'id' => 'dialog-modal-button',
      'class' => 'btn btn-primary', 
    ])?>
  </p>

  <!-- 设置 display:none; 使加载到 #modal-content 的表单不显示，再从中获取内容显示到 Dialog 中。-->
  <div id="modal-content" style="display: none;"></div>

  <?= Dialog::widget([
    'libName' => 'krajeeDialogCust',
    // 'useNative' => false,
    'options' => [
      'draggable' => true, 
      'closable' => true,
      // 这个属性设置成 true 时，纵向会出现大片 <br/> 形成的空白
      'nl2br' => false,
    ],
    'dialogDefaults' => [
      // 在这里设置按钮样式或隐藏按钮
      Dialog::DIALOG_OTHER => [
        'buttons' => ''
      ]
    ]
  ]); ?>
</div>

<?= $this->render('_editable_view', ['model' => $model, 'mode' => 'view']) ?>

