<?php

use common\assets\EuiAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RuneWordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = T('Rune Search');

$js = <<< JS
$(function(){
    $('.rune-word-name').on('click', function(){
        var html = $(this).attr('data')
        if (html){
            html = '<div style="width:100%;height:100%;">' + html + '</div>'
        }else{
            return
        }
        
        // console.log(html);
        $('.modal-body').html(html)
        $('#details-modal').modal()
    })

    // 初始化所有 popovers
    // $('[data-toggle="popover"]').popover(
    // {
    //     html: true,
    //     content: function(){
    //         console.log('a')
    //         var content = 'a<br/>b'
    //         console.log(content)
    //         return content
    //     }
    // }
    // );
})
JS;
$this->registerJs($js);

EuiAsset::register($this);
?>

<style type="text/css">

/* 匹配中的符文之语高亮显示 */
.matched-rune-word{
    background-color:#cebc86 !important;
    color: white;
}

/* 匹配中的符文之语名字换一下颜色 */
/* 
.matched-rune-word .rune-word-name{
    color: white;
} 
*/

.modal-content{
    border-bottom: 0 none;
    border-right: 0 none;
}

.modal-header {
    background-color: #1B1813;
    border-bottom: 0 none;
}

.modal-body{
    background-color: #1B1813;
    border-bottom: 0 none;
    padding: 0;
}

.modal-body table {
    width: 100%;
    height: 100%;
    color: #A18E73;
}

.modal-footer {
    border-bottom: 0 none;
}

</style>

<div class="rune-word-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php echo $this->render('_search', ['model' => $searchModel, 'dataProvider' => $dataProvider]); ?>
    </p>

    <?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    // 移除 striped 效果，会使奇数行高亮显示失效
    'tableOptions' => ['class' => 'table table-bordered'],
    'options' => [
        'class' => 'table-responsive',
    ],
    'rowOptions' => function($model, $key, $index) use (&$matched){
        // 匹配中的 row 增加高亮显示属性
        if ($matched[$index]['result'] == true) {
            return ['class' => 'matched-rune-word'];
        }
    },
    
    'summary' => "总计 {count} 条数据，符合条件的有 {$count} 条",
    'columns' => [
        [
            'attribute' => 'name',
            'format' => 'raw',
            'value' => function($model, $key, $index) use (&$matched){
                $name = $model->name . ' / ' . $model->cnName;
                // 没有从 Python 生成详情的符文之语标灰
                $name = Html::tag('span', $name, ['style' => empty($model->html) ? 'color:darkgrey;' : 'color:#a94442']);
                $name = Html::a($name, 'javascript:void(0);', ['class' => 'rune-word-name', 'data' => $model->html]);
                $equipments = "{$model->slots} 凹槽 $model->equipments";
                return $name . '<br/>' . $equipments;

                /* 
                - 使用 popover 展示使，内容中的 td 标签造成 html 类型的 popover 无法展示；
                - 将 td 标签替换为 div 后，可以展示，但失去所有 style；
                - 右键点击检查 popover 的属性，发现所有 table，tbody，tr 都被转换成了 div 标签，所有 styles 全部消失；
                - 所以改为使用 Modal 展示详情。
                return Html::a($name, '#', [
                    'data-toggle' => "popover", 
                    // 'data-trigger' => "focus",
                    'title' => $model->name, 
                    'data-content' => $model->html,  
                    // 'data-content' => '<span>狮心<br/>Lionheart</span><br/><span>3 凹槽 盔甲</span>', // OK
                    // 'data-content' => '<table><tbody><tr>aaa</tr></tbody></table>', // OK
                    // 'data-content' => '<table class="my-test" style="background:#000; border: 1px solid #2F0600; text-align: center;"><tbody><tr><div style="background:#2F0600; height: 70px; padding: .25em;"><span style="color: #cebc86; font-size: 1.4em; letter-spacing: .15em; margin: .25em; font-family: Georgia;">狮心<br/>Lionheart</span><br/><span style="font-size: .9em;">3 凹槽 盔甲</span></div></tr><tr style="height: .75em;"><div></div></tr><tr style="vertical-align: top;"><div><span style="font-size: .9em;"><a href="https://wiki.d.163.com/index.php?title=Hel_(Diablo_II)" title="Hel (Diablo II)">海尔</a> •<a href="https://wiki.d.163.com/index.php?title=Lum_(Diablo_II)" title="Lum (Diablo II)">卢姆</a> •<a href="https://wiki.d.163.com/index.php?title=Fal_(Diablo_II)" title="Fal (Diablo II)">法尔</a>
                    // <br/> Hel(15) + Lum(17) + Fal(19)</span><br/><span style="color: #CCCCCC; font-size: .9em;">需求等级:41<br/></span><br/><span style="color:#4169E1;">+20% 增强伤害<br/>需求 -15%<br/>+25 力量<br/>+10 精力<br/>+20 体力<br/>+15 敏捷<br/>+50 生命<br/>所有抗性 +30</span><br/></div></tr></tbody></table>
                    // ', // OK, replace td with div
                ]);
                */
            },
        ],
        // 'slots',
        // 'equipments',        
        // [
        //     'attribute' => 'equipments',
        //     'value' => function($model){
        //         return "[{$model->slots}] $model->equipments";
        //     }
        // ],
        [
            'attribute' => 'runes',
            'label' => TApp('Rune Order'),
            'format' => 'raw',
            'value' => function($model, $key, $index) use (&$matched){
                return $model->getBetterName($matched[$index]['marks']);
            }
        ],      
        'level',  
        'version',
    ],
]); ?>

</div>

<?php
use yii\bootstrap\Modal;

Modal::begin([
    'id' => 'details-modal',
    'size' => Modal::SIZE_DEFAULT,
    'header' => null,
    'closeButton' => false,
    'options' => [
        'class' => 'modal', // 消除 fade 效果
    ],
]);
Modal::end();
?>