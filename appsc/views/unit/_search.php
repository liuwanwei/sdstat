<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use appsc\models\Unit;

/* @var $this yii\web\View */
/* @var $model app\models\UnitSearch */
/* @var $form yii\widgets\ActiveForm */
$js = <<< JS
$(function(){
    $('#select-race').on('change', function(){
        var race = $(this).val()
        console.log('changed to race: ' + race);
        $('#unit-search-form').submit()
    })
})
JS;
$this->registerJs($js);
?>

<div class="unit-search inline-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
        'id' => 'unit-search-form'
    ]); ?>

    <?= $form->field($model, 'race')->dropDownList(Unit::RACES_FULL, ['id' => 'select-race']) ?>

    <?= $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-default']) ?>
    </div>    

    <?php ActiveForm::end(); ?>    

</div>
