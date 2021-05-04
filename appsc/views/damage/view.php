<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Damage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Damages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="damage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_view', ['model' => $model]) ?>

</div>
