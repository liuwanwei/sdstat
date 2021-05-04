<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DamageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="damage-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
    ]); ?>

    <?= $form->field($model, 'unitName') ?>

    <?php // echo $form->field($model, 'times') ?>

    <?php // echo $form->field($model, 'explosive') ?>

    <?php // echo $form->field($model, 'concussive') ?>

    <?php // echo $form->field($model, 'splash') ?>

    <?php // echo $form->field($model, 'range') ?>

    <?php // echo $form->field($model, 'rangeBonus') ?>

    <?php // echo $form->field($model, 'cooldown') ?>

    <?php // echo $form->field($model, 'cooldownBonus') ?>

    <?php // echo $form->field($model, 'dps') ?>

    <?php // echo $form->field($model, 'dpsBonus') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
