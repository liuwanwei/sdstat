<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */

$this->title = Yii::t('app', 'Create Unit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create-dialog">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_editable_view', [
        'model' => $model,
        'mode' => 'edit',
    ]) ?>

</div>
