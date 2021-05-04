<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BonusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bonus-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'type')->dropDownList(\app\models\Bonus::typeOptions(true)) ?>

    <?php // echo $form->field($model, 'image') 
    ?>

    <?php // echo $form->field($model, 'createdAt') 
    ?>

    <?php // echo $form->field($model, 'updatedAt') 
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>