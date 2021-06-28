<?php

use appsc\helpers\BonusHelper;
use appsc\models\Unit;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = TApp('Units');
$this->params['breadcrumbs'][] = $this->title;

$js = <<< JS
$(function(){
    $('.damage-btn').on("click", function(){
        var damageId = $(this).attr('value')
        var unitName = $(this).attr('unit-name')
        var url = '/damage/view'
        $.get(url, {'id': damageId, 'ajax': 1}, function(data){
            $('.modal-body').html(data)
            $('#modal-header').html(unitName + ' 攻击伤害')
        })
        $('#damage-modal').modal()
    })
})
JS;
$this->registerJs($js);
?>
<div class="unit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </p>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'race',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a(TApp($model->name), ['view', 'id' => $model->id]);
                }
            ],
            // 'typeNAME',
            [
                'attribute' => 'type',
                'value' => function($model) {
                    return Trans(Unit::TYPES)[$model->type];
                }
            ],
            // 'forceNAME',
            [
                'attribute' => 'force',
                'value' => function ($model) {
                    return Trans(Unit::FORCES)[$model->force];
                }
            ],
            'mineCost',
            'gasCost',
            'timeCost',
            'unitCost',
            'hp',            
            'armor',
            'shield',
            // 'energy',
            [
                'attribute' => 'sight',
                'value' => function($model) { return BonusHelper::bonusRange($model, 'sight'); }
            ],
            // 'sightBonus',
            [
                'attribute' => 'speedBonus',
                'value' => function ($model) { return BonusHelper::bonusRange($model, 'speed'); }
            ],
            [
                'label' => TApp("Damage"),
                'format' => 'raw',
                'value' => function($model) {
                    $damages = $model->damages;
                    $a = '';
                    foreach ($damages as $damage) {
                        if(! empty($a)){
                            $a .= '&nbsp;|&nbsp;';
                        }

                        $a .= Html::a($damage->scopeNAME, 'javascript:void(0);', ['class' => 'damage-btn', 'value' => $damage->id, 'unit-name' => $model->name]);
                    }

                    return $a;
                }
            ],

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php
    \yii\bootstrap\Modal::begin([
        'id' => 'damage-modal',
        'header' => '<h4 id="modal-header">攻击伤害</h4>'
    ]);
    \yii\bootstrap\Modal::end();
    ?>

</div>
