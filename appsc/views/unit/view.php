<?php

/* @var $this yii\web\View */
/* @var $model app\models\Unit */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => TApp($model->raceString(true)), 'url' => ['index', 'race' => $model->race]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
// BonusAsset::register($this);
?>

<?= $this->render('_editable_view', ['model' => $model, 'mode' => 'view']) ?>

<?= $this->render('_bonus_index', ['model' => $model, 'dataProvider' => $dataProvider]) ?>