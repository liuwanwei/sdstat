<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Damage */

$this->title = 'Update Damage: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Damages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="damage-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
