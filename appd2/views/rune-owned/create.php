<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RuneOwned */

$this->title = Yii::t('app', 'Create Rune Owned');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rune Owneds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rune-owned-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
