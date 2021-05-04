<?php

use app\models\Bonus;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Bonus */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
    var \$form = $('#create-bonus-form')
    console.log(\$form.length)
    if (\$form.length > 0) {
        \$form.on('submit', function(e){    
            // var \$form = $(this)
            $.post(
                \$form.attr('action'), 
                \$form.serialize()
            ).done(function(result){
                console.log('got result: ' + result)
            })

            return false
        })
    }        
JS;
$this->registerJs($js);


?>

<div class="bonus-form">

    <?php $form = ActiveForm::begin([
        'id' => 'create-bonus-form'
    ]); ?>

    <?= $form->field($model, 'type')->dropDownList(Bonus::typeOptions()) ?>
    <?= $form->field($model, 'scope')->dropDownList(Bonus::scopeOptions()) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'value')->textInput() ?>
    <?= $form->field($model, 'mineCost')->textInput() ?>
    <?= $form->field($model, 'gasCost')->textInput() ?>
    <?= $form->field($model, 'timeCost')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>