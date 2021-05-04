<?php
?>

<?= $form->field($model, 'gDamage')->textInput() ?>

<?= $form->field($model, 'gDamageUpStep')->textInput() ?>

<?= $form->field($model, 'gDamageRange')->textInput() ?>

<?= $form->field($model, 'gDamageRangeBonus')->textInput() ?>

<?= $form->field($model, 'gCooldown')->textInput() ?>

<?= $form->field($model, 'gCooldownBonus')->textInput() ?>

<?= $form->field($model, 'gAttacks')->dropDownList([1 => '1', 2 => '2']) ?>