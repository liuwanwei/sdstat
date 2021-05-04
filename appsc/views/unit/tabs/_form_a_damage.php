<?php
?>


<?= $form->field($model, 'aDamage')->textInput() ?>

<?= $form->field($model, 'aDamageUpStep')->textInput() ?>

<?= $form->field($model, 'aDamageRange')->textInput() ?>

<?= $form->field($model, 'aDamageRangeBonus')->textInput() ?>

<?= $form->field($model, 'aCooldown')->textInput() ?>

<?= $form->field($model, 'aCooldownBonus')->textInput() ?>

<?= $form->field($model, 'aAttacks')->dropDownList([1 => '1', 2 => '2']) ?>