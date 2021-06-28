<?php

// 使用 ECharts 的 bar 图展示。
// ECharts 安装
// https://www.runoob.com/echarts/echarts-install.html
// echarts.js 使用
// https://echarts.apache.org/zh/tutorial.html
// bar 图例子
// https://echarts.apache.org/v4/examples/zh/editor.html?c=bar-y-category-stack


\appsc\assets\EChartsAsset::register($this);
// $this->registerJs('js/echarts.min.js', $this::POS_HEAD);
?>

<?= $this->render('_search', ['model' => $searchModel]) ?>

<p>
<div id="main" style="width: 1024px; height:1080px;"></div>
</p>

<script type="text/javascript">
    var names = JSON.parse('<?php echo $names ?>')
    var baseValues = JSON.parse('<?php echo $baseValues ?>')
    var bonusValues = JSON.parse('<?php echo $bonusValues ?>')
    createRank(names, baseValues, bonusValues)

    function createRank(names, baseValues, bonusValues){
        var myChart = echarts.init(document.getElementById('main'))
        console.log(myChart)
        var option = {
            title: {
                text: '速度排行'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow',
                }
            },
            legend: {
                data:['初始速度', '升级速度']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                // name: '速度',
                interval: 0.5              
            },
            yAxis: {                
                type: 'category',
                // name: '兵种',
                inverse: true,
                data: names
            },
            series: [
                {
                    name: '初始速度',
                    type: 'bar',
                    stack: '总量',
                    label: {
                        show: true,
                        position: 'insideRight'
                    },
                    data: baseValues
                },
                {
                    name: '升级速度',
                    type: 'bar',
                    stack: '总量',
                    label: {
                        show: true,
                        position: 'insideRight'
                    },
                    data: bonusValues
                }
            ]
        }

        myChart.setOption(option)
    }
</script>