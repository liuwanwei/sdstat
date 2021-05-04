<?php

use app\helpers\BonusHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DamageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Damages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="damage-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </p>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'unit.name',
            'scopeNAME',
            'base',
            'stride',
            'times',
            'explosive:boolean',
            'concussive:boolean',
            'splash:boolean',
            [
                'attribute' => 'range',
                'value' => function($model){ return BonusHelper::bonusRange($model, 'range'); }
            ],
            [
                'attribute' => 'cooldown',
                'value' => function($model){ return BonusHelper::bonusRange($model, 'cooldown'); }
            ],
            [
                'attribute' => 'dps',
                'value' => function($model){ return BonusHelper::bonusRange($model, 'dps'); }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
