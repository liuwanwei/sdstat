<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\dialog\Dialog;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Units');
$this->params['breadcrumbs'][] = $this->title;

// 传递 PHP 字符串给 JS 字符串，似乎只有这种办法，不能直接在下面 JS 中调用 PHP 函数
// $formUri = Url::to(['unit/d-create']);
// $js = <<< JS
// $(function(){
//     $("#create-unit-button").on("click", function () {        
//         // 加载 views/unit/_form.php 的内容，展示在对话框中
//         var url = "$formUri"
//         htmlObj = $.ajax({url:url, async:false});
//         krajeeDialogCust.dialog(
//             htmlObj.responseText,
//             function (result) {
//                 alert(result)
//             }
//         )        
//     })    
// })
// JS;
// $this->registerJs($js);
?>


<div class="unit-index">
    <!-- <div class="model-title">
        <div class="model-name">
            <?= Html::encode($this->title) ?>
        </div>
        <div>
            <?= Html::a(Yii::t('app', 'Create'), ['unit/create'], ['class' => 'btn btn-success', 'id' => 'create-unit-button']) ?>
        </div>
    </div> -->

    <div>
        <?= Html::a(TApp('Create'), ['unit/create'], ['class'=>'btn btn-success']); ?>
    </div>

    <p>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </p>

    <?= Dialog::widget([
        'libName' => 'krajeeDialogCust',
        'id' => 'liuwanwei',
        'options' => [
            'draggable' => true,
            'closable' => true,
            // 关闭点击外围空白区域来关闭对话框功能
            'closeByBackdrop' => true,
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

    <?php Pjax::begin(['id' => 'units-grid']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'order',
            // ['attribute' => 'race', 'value' => function($model){ return $model->raceString();}],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = '( ' . $model->raceString() . ' ) ' . $model->name;
                    return Html::a($text, ['unit/view', 'id' => $model->id]);
                }
            ],
            // 'nickname',
            ['attribute' => 'type', 'value' => function ($model) {
                return $model->typeString() . ' ' . $model->forceString();
            }],
            // ['attribute' => 'force', 'value' => function($model){ return $model->forceString();}],
            ['attribute' => 'health', 'value' => function ($model) {
                if ($model->shield) {
                    return "{$model->health}/{$model->shield}";
                } else {
                    return $model->health;
                }
            }],
            // 'shield',
            // 'gDamage',
            ['attribute' => 'gDamage', 'value' => function ($model) {
                if ($model->gDamage) {
                    $range = "R$model->gDamageRange";
                    if ($model->gDamageRangeBonus) {
                        $range .= "/{$model->gDamageRangeBonus}";
                    }
                    return "{$model->gDamages()} ($range)";
                }
            }],
            ['attribute' => 'aDamage', 'value' => function ($model) {
                if ($model->aDamage) {
                    $range = "R$model->aDamageRange";
                    if ($model->aDamageRangeBonus) {
                        $range .= "/{$model->aDamageRangeBonus}";
                    }
                    return "{$model->aDamages()} ($range)";
                }
            }],
            ['label' => 'Damage', 'value' => function ($model) {
                if ($model->concussive) {
                    return 'Con';
                } else if ($model->explosive) {
                    return 'Exp';
                } else {
                    return 'Normal';
                }
            }],

            'defense',

            ['attribute' => 'sight', 'value' => function ($model) {
                if (!empty($model->sightBonus)) {
                    return "{$model->sight}/{$model->sightBonus}";
                } else {
                    return $model->sight;
                }
            }],

            ['attribute' => 'speed', 'value' => function ($model) {
                if (!empty($model->speedBonus)) {
                    return "{$model->speed}/{$model->speedBonus}";
                } else {
                    return $model->speed;
                }
            }],
            ['label' => 'Cooldown', 'value' => function ($model) {
                $cooldown = '';
                if (!empty($model->gCooldown)) {
                    $cooldown = "{$model->gCooldown}";
                    if (!empty($model->gCooldownBonus)) {
                        $cooldown .= '/' . "{$model->gCooldownBonus}";
                    }
                }

                if (!empty($model->aCooldown)) {
                    if (!empty($cooldown)) {
                        $cooldown .= " | ";
                    }

                    $cooldown .= "{$model->aCooldown}";
                    if (!empty($model->aCooldownBonus)) {
                        $cooldown .= "/{$model->aCooldownBonus}";
                    }
                }
                return $cooldown;
            }],
            ['label' => 'Attack', 'value' => function ($model) {
                if ($model->concussive) {
                    return '震荡式';
                } else if ($model->explosive) {
                    return '爆炸式';
                } else {
                    return '普通';
                }
            }],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-trash"></span>',
                            Url::to(['unit/delete', 'id' => $model->id, 'from' => 'index']),
                            [
                                'title' => '删除',
                                'aria-label' => "删除",
                                'data-pjax' => '0',
                                'data-confirm' => '您确定要删除此项吗？',
                                'data-method' => 'post'
                            ]
                        );
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end() ?>

</div>