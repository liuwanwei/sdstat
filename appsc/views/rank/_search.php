<?php
use kartik\widgets\ActiveForm;
use appsc\models\Unit;
use buddysoft\widget\helpers\OptionHelper;
use yii\helpers\Html;

?>

<div class="speed-rank-search">

    <?php $form = ActiveForm::begin([
        'action' => ['speed'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
    ]); ?>

    <?= $form->field($model, 'race')->dropDownList(OptionHelper::addNullOption(Trans(Unit::RACES), '种族')) ?>

    <?= $form->field($model, 'force')->dropDownList(OptionHelper::addNullOption(Trans(Unit::FORCES), '兵种')) ?>

    <?= $form->field($model, 'mode')->dropDownList([0 => '初始速度', 1 => '升级速度']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-default']) ?>
    </div>    

    <?php ActiveForm::end(); ?>    

</div>