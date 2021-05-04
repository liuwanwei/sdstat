<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Damage */

$this->title = 'Create Damage';
$this->params['breadcrumbs'][] = ['label' => 'Damages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="damage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
