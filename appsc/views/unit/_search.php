<?php

use appsc\models\Unit;
use buddysoft\widget\helpers\OptionHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UnitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
    ]); ?>

    <?= $form->field($model, 'race')->dropDownList(OptionHelper::addNullOption(Trans(Unit::RACES), '种族')) ?>

    <?= $form->field($model, 'category')->dropDownList(OptionHelper::addNullOption(Trans(Unit::CATEGORIES), '类型')) ?>

    <?= $form->field($model, 'type')->dropDownList(OptionHelper::addNullOption(Trans(Unit::TYPES), '体积')) ?>

    <?= $form->field($model, 'damageEffect')->dropDownList(OptionHelper::addNullOption(Trans(Unit::DAMAGE_EFFECTS), '所有伤害类型')) ?>

    <div class="form-group">
        <?= Html::submitButton(TApp('Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
