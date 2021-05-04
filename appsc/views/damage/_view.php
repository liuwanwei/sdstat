<?php

use app\helpers\BonusHelper;
use yii\widgets\DetailView;
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        // 'id',
        // 'unitId',
        'scopeNAME',
        'base',
        'stride',
        'times',
        'explosive:boolean',
        'concussive:boolean',
        'splash:boolean',
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
        [
            'attribute' => 'dps',
            'value' => BonusHelper::bonusRange($model, 'dps'),
        ],
        // 'dpsBonus',
    ],
]) ?>