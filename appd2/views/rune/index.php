<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RuneSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Runes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rune-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // echo Html::a(Yii::t('app', 'Import Rune'), ['import'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            // 'index',
            [
                'attribute' => 'name',
                'value' => function($model){
                    return $model->getCombinedName();
                }
            ],
            'level',
            'dropRate',
            'boss',
            'difficulty',
            'img:image',
            //'formula:ntext',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
