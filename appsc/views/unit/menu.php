<?php

use yii\helpers\Html;

$this->title = "导入";
$this->params['breadcrumbs'][] = ['label' => T('Units'), 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <p><?= Html::a('从 Excel 导入数据', ['import'], [
        'class' => 'btn btn-warning',
        'data' => [
            'confirm' => '确定要重新导入吗?'
        ]
    ]) ?></p>
    <p><?= Html::a('清除 memcache 缓存', ['flush-cache'], ['class' => 'btn btn-success']) ?></p>
</div>