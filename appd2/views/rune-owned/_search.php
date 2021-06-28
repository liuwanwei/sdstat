<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RuneOwnedSearch */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
$('#runeownedsearch-morethanone').on('change', function(){
    $('#rune-owned-search-form').submit()
})
JS;
$this->registerJs($js);
?>

<div class="rune-owned-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
        'id' => 'rune-owned-search-form'
    ]); ?>

    <?= $form->field($model, 'moreThanOne')->dropDownList([null => '所有符文', '1' => '只看拥有']) ?>

    <div class="form-group">
        <?php // echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
