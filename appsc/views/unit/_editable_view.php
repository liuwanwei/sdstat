<?php

use appsc\models\Unit;
use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;

$sectionOptions = ['class' => 'info'];

// DetailView Attributes Configuration
$attributes = [
    [
        'group' => true,
        'label' => TApp('Basic Attributes'),
        'rowOptions' => $sectionOptions,
    ],
    [
        'columns' => [
            [
                'attribute' => 'name',
                'value' => $model->name,
                'valueColOptions' => ['style' => 'width:30%'],
                // 'displayOnly' => true
            ],
            [
                'attribute' => 'race',
                'value' => $model->raceString(),
                'type' => DetailView::INPUT_DROPDOWN_LIST,
                'items' => Unit::RACES,
                'valueColOptions' => ['style' => 'width:30%']
            ],
        ],
    ],
    [
        'columns' => [
            [
                'attribute' => 'type',
                'value' => $model->typeString(),
                'type' => DetailView::INPUT_DROPDOWN_LIST,
                'items' => Unit::TYPES,
                'valueColOptions' => ['style' => 'width:30%'],
            ],
            [
                'attribute' => 'force',
                'value' => $model->forceString(),
                'type' => DetailView::INPUT_DROPDOWN_LIST,
                'items' => Unit::FORCES,
                'valueColOptions' => ['style' => 'width:30%'],
            ],
        ],
    ],[
        'columns' => [
            [
                'attribute' => 'health',
                'valueColOptions' => ['style' => 'width:30%'],
            ],
            [
                'attribute' => 'shield',
                'format' => 'raw',
                'valueColOptions' => ['style' => 'width:30%'],
            ],
        ],
    ],[
        'columns' => [
            [
                'attribute' => 'defense',
                // 'value'
                'valueColOptions' => ['style' => 'width:30%'],
            ],
            [
                'attribute' => 'order',
                // 'value'
                'valueColOptions' => ['style' => 'width:30%'],
            ],            
        ],         
    ],
    [
        'columns' => [
            [
                'attribute' => 'sight',
                'valueColOptions' => ['style' => 'width:30%'],
            ],
            [
                'attribute' => 'speed',
                'valueColOptions' => ['style' => 'width:30%'],
            ],
        ],
    ],
    [
        'group' => true,
        'label' => TApp('Damage Attributes'),
        'rowOptions' => $sectionOptions,   
    ],
    [
        'columns' => [
            [
                'attribute' => 'gDamage',
                'valueColOptions' => ['style' => 'width:13%'],
            ],
            [
                'attribute' => 'gDamageRange',
                'valueColOptions' => ['style' => 'width:13%'],
            ],
            [
                'attribute' => 'gAttacks',
                'value' => Unit::ATTACKS[$model->gAttacks],
                'type' => DetailView::INPUT_DROPDOWN_LIST,
                'items' => Unit::ATTACKS,
                'valueColOptions' => ['style' => 'width:13%'],
            ],            
        ]
    ],[
        'columns' => [
            [
                'attribute' => 'aDamage',
                'valueColOptions' => ['style' => 'width:13%'],
            ],
            [
                'attribute' => 'aDamageRange',
                'valueColOptions' => ['style' => 'width:13%'],
            ],
            [
                'attribute' => 'aAttacks',
                'value' => Unit::ATTACKS[$model->aAttacks],
                'type' => DetailView::INPUT_DROPDOWN_LIST,
                'items' => Unit::ATTACKS,
                'valueColOptions' => ['style' => 'width:13%'],
            ]
        ],
    ],
    [
        'group' => true,
        'label' => TApp('Special Damage Attributes'),
        'rowOptions' => $sectionOptions,
    ], [
        'columns' => [
            [
                'attribute' => 'explosive',
                // 'format' => 'raw',
                'value' => $model->explosive ? 'Yes':'No',
                'valueColOptions' => ['style' => 'width:13%'],
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Yes',
                        'offText' => 'No',
                    ]
                ]
            ], [
                'attribute' => 'concussive',
                // 'format' => 'raw',
                'value' => $model->concussive ? 'Yes' : 'No',
                'valueColOptions' => ['style' => 'width:13%'],
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Yes',
                        'offText' => 'No',
                    ]
                ],
            ], [
                'attribute' => 'splash',
                // 'format' => 'raw',
                'value' => $model->splash ? 'Yes' : 'No',
                'valueColOptions' => ['style' => 'width:13%'],
                'type' => DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Yes',
                        'offText' => 'No',
                    ]
                ],
            ]
        ]
    ]
    // [
    //     'group' => true,
    //     'label' => 'Record Time',
    //     'rowOptions' => $sectionOptions,
    // ], [
    //     'columns' => [
    //         [
    //             'attribute' => 'createdAt',
    //             'displayOnly' => true
    //         ],[
    //             'attribute' => 'updatedAt',
    //             'displayOnly' => true
    //         ]
    //     ],
    // ],
];

if ($model->isNewRecord) {
    $heading = TApp('Create');
}else{
    $text = $model->raceString(true) . ' - ' . $model->name;
    $heading = Html::a($text, $model->liquidUrl(), ['target' => '_blank']);
}

?>
<div class="editable-details-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
        'mode' => $mode,
        'panel' => [
            'heading' => $heading,
            'type' => DetailView::TYPE_DEFAULT,
        ],
        // 'bordered' => $bordered,
        // 'striped' => $striped,
        // 'condensed' => $condensed,
        'responsive' => true,
        // 'hover' => $hover,
        'hAlign' => DetailView::ALIGN_LEFT,
        // 'vAlign' => $vAlign,
        // 'fadeDelay' => $fadeDelay,
        'deleteOptions' => [ // your ajax delete parameters
            'url' => Url::to(['unit/delete', 'id' => $model->id]),
            // 'params' => ['id' => $model->id, 'kvdelete' => true],
        ],
        'container' => ['id' => 'kv-demo'],
        'buttons1' => '{update}',
        'buttons2' => '{view}{save}',
        // 'formOptions' => ['action' => Url::current(['#' => 'kv-demo'])] // your action to delete
    ]); ?>

</div>