<?php

use kartik\popover\PopoverX;
?>
<?= \kartik\grid\GridView::widget([
    'id' => 'editable-grid-view',
    'options' => [
        // 'class' => 'table-responsive',
    ],
    'dataProvider' => $dataProvider,
    'summary' => false,
    'columns' => [
        [            
            'attribute' => 'rune.name',
            'value' => function($model){
                return $model->rune->getCombinedName();
            }
        ],
        // 'rune.img:image',
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'count',
            'readonly' => !$editable,
            'editableOptions' => [
                'formOptions' => ['action' => ['rune-owned/edit']],
                'inputType' => \kartik\editable\Editable::INPUT_SPIN,
                'options' => ['pluginOptions' => ['min' => 0, 'max' => 1000]],
                'placement' => PopoverX::ALIGN_BOTTOM_LEFT,
            ]
        ],
    ],
]); ?>

<style type="text/css">

/**
 * 下面代码从引用的库 kartik-grid.css 中抄来，原先的 max-width: 480px，现在想修改到 320px，但是没有匹配中这个规则。
 * 要是在 kartik-grid.css 里把下面的 !important 注释掉，自定义这个规则就匹配中、就生效了。
 * 请问：这是不是 !important 影响的？是它影响的。
 */
@media screen and (min-width: 320px) {
    .kv-table-wrap th, .kv-table-wrap td {
        display: table-cell !important;
        /* width: 100% !important; */
        text-align: start;
        /* font-size: 1.2em; */
    }

    .kv-grid-container .kv-table-wrap tr > td:first-child {
        border-top: 1px;
        margin-top: 0px;
        font-size: 14px;
    }
}

/**
 * 使用 kartik/grid/gridview 后，左侧会引入莫名的两个缩紧，消除掉
 */
.row{
   margin-right: 0; 
   margin-left: 0;
}

</style>
