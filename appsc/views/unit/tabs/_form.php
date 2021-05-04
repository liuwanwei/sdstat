<?php

use kartik\tabs\TabsX;
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
var \$form = $('#create-unit-form')
console.log('obj length: ' + \$form.length)
if (\$form.length > 0) {
    \$form.on('beforeSubmit', function(e){    
        console.log('before submit')
        $.post(
            \$form.attr('action'), 
            \$form.serialize()
        ).done(function(result){
            console.log('create unit result: ' + result)
            if (result == 'success') {
                // #liuwanwei 在 views/unit/index.php 中定义，它是 modal 结点
                $(document).find('#liuwanwei').modal('hide')
                $.pjax.reload({container: '#units-grid'})
            }
        })

        return false
    })
}        
JS;

$this->registerJs($js, View::POS_END);
?>

<div class="unit-form">

    <?php $form = ActiveForm::begin([
        'id' => 'create-unit-form',
    ]); ?>

    <?php 
    echo TabsX::widget([
        // 'position'=>TabsX::POS_LEFT,
        'bordered' => true,
        'items' => [
            [
                'label' => 'Basic',
                'content' => $this->render('_form_basic', ['model' => $model, 'form' => $form]),
                'active' => true,
            ],
            [
                'label' => 'Ground Damage',
                'content' => $this->render('_form_g_damage', ['model' => $model, 'form' => $form]),
                'active' => false,
            ],
            [
                'label' => 'Air Damage',
                'content' => $this->render('_form_a_damage', ['model' => $model, 'form' => $form]),
                'active' => false,
            ],
            [
                'label' => 'Defense',
                'content' => $this->render('_form_defense', ['model' => $model, 'form' => $form]),
                'active' => false,
            ],
        ]
    ]) 
    ?>

    <div class="form-group">
        <?= Html::submitButton(TApp('Save'), ['class' => 'btn btn-success']) ?>
        <?= Html::a(TApp('Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>