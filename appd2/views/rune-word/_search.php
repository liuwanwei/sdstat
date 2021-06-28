<?php

use buddysoft\widget\helpers\OptionHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\RuneWordSearch */
/* @var $form yii\widgets\ActiveForm */

$levels = ArrayHelper::map($dataProvider->allModels, 'level', 'level');
asort($levels); // 使用 asort 能保留数组的 key，sort 和 array_sort 都不行呢。

$js = <<<JS
function submitSearch(){
    $('#search-form').submit()
}

$(function(){
    $('#resultscope').on('change', function(){
        submitSearch()
    })
    $('#category').on('change', function(){
        submitSearch()
    })
    $('#slots').on('change', function(){
        submitSearch()
    })
    $('#level').on('change', function(){
        submitSearch()
    })
})
JS;
$this->registerJs($js);

?>

<style type="text/css">
/* 为手机上显示时不换行而修改，原先设置为 768px 以上生效 */
@media (min-width: 320px){
    .form-inline .form-group {
        display: inline-block;
        margin-bottom: 0;
    }
}
</style>

<div class="rune-word-search">

    <?php $form = ActiveForm::begin([
        'id' => 'search-form',
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
    ]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'category')->dropDownList([null => '装备', '盔甲' => '盔甲', '头盔' => '头盔', '盾牌' => '盾牌', '武器' => '武器']) ?>

    <?php echo $form->field($model, 'slots')->dropDownList([null => TApp('Slots'), '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6']) ?>

    <?php echo $form->field($model, 'level')->dropDownList(OptionHelper::addNullOption($levels, TApp('Level'))) ?>

    <?php echo $form->field($model, 'resultScope')->dropDownList([null => '所有结果', '1' => '我能合成']) ?>

    <?php // echo $form->field($model, 'maxRune') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'html') ?>

    <div class="form-group">        
        <?php // echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php // Html::a(TApp('Rune Owneds'), ['/rune-owned/index'], ['class' => 'btn btn-default', 'id' => 'rune-owneds', 'target' => '_blank']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>