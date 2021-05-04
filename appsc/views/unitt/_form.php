<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'race')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'force')->textInput() ?>

    <?= $form->field($model, 'mineCost')->textInput() ?>

    <?= $form->field($model, 'gasCost')->textInput() ?>

    <?= $form->field($model, 'timeCost')->textInput() ?>

    <?= $form->field($model, 'unitCost')->textInput() ?>

    <?= $form->field($model, 'hp')->textInput() ?>

    <?= $form->field($model, 'shield')->textInput() ?>

    <?= $form->field($model, 'armor')->textInput() ?>

    <?= $form->field($model, 'energy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sight')->textInput() ?>

    <?= $form->field($model, 'sightBonus')->textInput() ?>

    <?= $form->field($model, 'speed')->textInput() ?>

    <?= $form->field($model, 'speedBonus')->textInput() ?>

    <?= $form->field($model, 'createdAt')->textInput() ?>

    <?= $form->field($model, 'updatedAt')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
