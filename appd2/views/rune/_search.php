<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RuneSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rune-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'index') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'cnName') ?>

    <?= $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'dropRate') ?>

    <?php // echo $form->field($model, 'boss') ?>

    <?php // echo $form->field($model, 'difficulty') ?>

    <?php // echo $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'formula') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
