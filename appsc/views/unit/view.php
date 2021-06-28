<?php

use app\helpers\BonusHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="unit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'race',
            'name',
            'type',
            'force',
            'mineCost',
            'gasCost',
            'timeCost',
            'unitCost',
            'hp',
            'shield',
            'armor',
            'energy',
            [
                'attribute' => 'sight',
                'value' => BonusHelper::bonusRange($model, 'sight'),
            ],
            // 'sightBonus',
            [
                'attribute' => 'speed',
                'value' => BonusHelper::bonusRange($model, 'speed'),
            ],
            // 'speed',
            // 'speedBonus',
            // 'createdAt',
            'updatedAt',
        ],
    ]) ?>

</div>
