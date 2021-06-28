<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RuneWord */

$this->title = Yii::t('app', 'Create Rune Word');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rune Words'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rune-word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
