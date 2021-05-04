<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Damage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="damage-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'unitId')->textInput() ?>

    <?= $form->field($model, 'scope')->textInput() ?>

    <?= $form->field($model, 'base')->textInput() ?>

    <?= $form->field($model, 'stride')->textInput() ?>

    <?= $form->field($model, 'times')->textInput() ?>

    <?= $form->field($model, 'explosive')->textInput() ?>

    <?= $form->field($model, 'concussive')->textInput() ?>

    <?= $form->field($model, 'splash')->textInput() ?>

    <?= $form->field($model, 'range')->textInput() ?>

    <?= $form->field($model, 'rangeBonus')->textInput() ?>

    <?= $form->field($model, 'cooldown')->textInput() ?>

    <?= $form->field($model, 'cooldownBonus')->textInput() ?>

    <?= $form->field($model, 'dps')->textInput() ?>

    <?= $form->field($model, 'dpsBonus')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
