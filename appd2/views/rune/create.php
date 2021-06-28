<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rune */

$this->title = Yii::t('app', 'Create Rune');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Runes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rune-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
