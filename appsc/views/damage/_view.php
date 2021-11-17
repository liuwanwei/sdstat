<?php

use appsc\helpers\BonusHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        // 'id',
        // 'unitId',
        'scopeNAME',
        'base',
        [
            'attribute' => 'dps',
            'value' => BonusHelper::bonusRange($model, 'dps'),
        ],
        'stride',
        'times',
        [
            'attribute' => 'explosive',
            'visible' => $model->explosive,
            'format' => 'raw',
            'value' => function($model) {
                if ($model->explosive) {
                    return Html::img(ICON_EXPLOSIVE, ['width'=>25, 'height' => 25]);
                }
            }
        ],
        [
            'attribute' => 'concussive',
            'format' => 'raw',
            'visible' => $model->concussive,
            'value' => function($model) {
                if ($model->concussive) {
                    return Html::img(ICON_CONCUSSIVE, ['width'=>25, 'height' => 25]);
                }
            }
        ],
        [
            'attribute' => 'splash',
            'format' => 'raw',
            'visible' => $model->splash,
            'value' => function($model) {
                if ($model->splash) {
                    return Html::img(ICON_SPLASH, ['width'=>25, 'height' => 25]);
                }
            }
        ],
        [
            'attribute' => 'range',
            'value' => BonusHelper::bonusRange($model, 'range'),
        ],
        // 'rangeBonus',
        [
            'attribute' => 'cooldown',
            'value' => BonusHelper::bonusRange($model, 'cooldown'),
        ],
        // 'cooldownBonus',        
        // 'dpsBonus',
    ],
]) ?>