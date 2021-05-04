<?php

use app\models\Unit;
?>

<?= $form->field($model, 'race')->dropDownList([0 => 'P', 1 => 'T', 2 => 'Z']) ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'type')->dropDownList(Unit::TYPES) ?>

<?= $form->field($model, 'force')->dropDownList([0 => 'Ground', 1 => 'Air']) ?>

<?= $form->field($model, 'health')->textInput() ?>

<?= $form->field($model, 'shield')->textInput() ?>

<?= $form->field($model, 'sight')->textInput() ?>

<?= $form->field($model, 'speed')->textInput() ?>