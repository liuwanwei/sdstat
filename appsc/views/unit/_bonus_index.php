<?php
use app\assets\BonusAsset;
use kartik\dialog\Dialog;
use yii\bootstrap\Html;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$url = Url::to(['bonus/create', 'unitId' => $model->id]);
$js = <<< JS
$(function(){
  // Success: use kartik dialog
  $("#modal-button").on("click", function () {
      $('#modal-content').load("$url", function (response, status, xhr) {
          krajeeDialogCust.dialog(
              response,
              function (result) {
                  alert(result);
              }
          );
      })        
  });
})
JS;

$this->registerJs($js);
?>

<div class="unit-view">
  <p>
    <?= Html::button('Create Bonus', ['class' => 'btn btn-default', 'id' => 'modal-button']) ?>
  </p>

  <?= Dialog::widget([
        'libName' => 'krajeeDialogCust',
        'id' => 'create-bonus-dialog',
        'options' => [
            'draggable' => true, 
            'closable' => true,
            // 关闭点击外围空白区域来关闭对话框功能
            // 'closeByBackdrop' => false,
            // 这个属性设置成 true 时，纵向会出现大片 <br/> 形成的空白
            'nl2br' => false,
        ],        
        'dialogDefaults' => [            
            // 在这里设置按钮样式或隐藏按钮
            Dialog::DIALOG_OTHER => [
                'buttons' => ''
            ]
        ]
    ]); 
  ?>

  <!-- 表单内容容器 -->
  <div id="modal-content" style="display: none;"></div>

</div>

<?php Pjax::begin(['id' => 'bonux-index-container']);?>
<div id="unit-bonus-index">
  <!-- <div style="padding-left:2px;">
  <H5>属性加成: </H5>
  </div> -->
  
  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'summary' => false,
    'columns' => [
        'name',
        [ 
          'attribute' => 'type', 
          'value' => function($model) { return TApp(BONUS_TYPES[$model->type]);}
        ],
        [
          'attribute' => 'scope',
          'value' => function($model) { return TApp(BONUS_SCOPES[$model->scope]);}
        ],
        'value',
        'mineCost',
        'gasCost',
        'timeCost',
        [
          'class' => 'yii\grid\ActionColumn', 
          'template' => '{update} {delete}',
          'buttons' => [
            'update' => function($url, $model, $key){
              $newUrl = Url::to(['/bonus/update', 'id' => $model->id, 'from' => 'unit-view']);
              return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $newUrl);
            },
            'delete' => function($url, $model, $key){
              return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                Url::to(['bonus/delete', 'id' => $model->id, 'from' => 'unit-view']),
                [
                    'title' => '删除',
                    'aria-label' => "删除",
                    'data-pjax' => '0',
                    'data-confirm' => '您确定要删除此项吗？',
                    'data-method' => 'post'
                ]);
            }
          ]
        ],
    ],
  ]); ?>
</div>
<?php Pjax::end(); ?>