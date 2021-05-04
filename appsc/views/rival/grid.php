<?php

use yii\grid\GridView;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    ['label' => '', 'value' => function($model){ return 'vs';}],
    'defender.name',
    'baseDamage',
    ['label' => 'Damage Type Factor', 'value' => function($model){
        if (!empty($model->typeFactor)) {
            return "{$model->typeName}: {$model->typeFactor}";
        }
    }],
    'damage',
];
if ($searchModel->defenderRace == 0) {
    $columns[] = 'shieldDamage';
}
$columns[] = ['class' => 'yii\grid\ActionColumn'];
?>

<div class="rival-list">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]); ?>


</div>