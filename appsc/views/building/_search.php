<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model appsc\models\BuildingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="building-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'race') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'mineCost') ?>

    <?= $form->field($model, 'gasCost') ?>

    <?php // echo $form->field($model, 'timeCost') ?>

    <?php // echo $form->field($model, 'hp') ?>

    <?php // echo $form->field($model, 'shield') ?>

    <?php // echo $form->field($model, 'armor') ?>

    <?php // echo $form->field($model, 'createdAt') ?>

    <?php // echo $form->field($model, 'updatedAt') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
