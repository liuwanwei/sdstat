<?php
use kartik\widgets\ActiveForm;
use appsc\models\Unit;
use buddysoft\widget\helpers\OptionHelper;
use yii\helpers\Html;

?>

<div class="speed-rank-search">

    <?php $form = ActiveForm::begin([
        'id' => 'speed-search-form',
        'action' => ['speed'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
    ]); ?>

    <?= $form->field($model, 'race')->dropDownList(OptionHelper::addNullOption(Trans(Unit::RACES), '所有种族')) ?>

    <?= $form->field($model, 'force')->dropDownList(OptionHelper::addNullOption(Trans(Unit::FORCES), '所有兵种')) ?>

    <?= $form->field($model, 'mode')->dropDownList([0 => '原始速度', 1 => '升级后速度']) ?>

    
    <?php ActiveForm::end(); ?>    

</div>