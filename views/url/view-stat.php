<?php
/* @var $this yii\web\View */

$this->registerJs("
Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Chart'
        },
        xAxis: {
            categories: $dates
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total query'
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
            }
        },
        series: $statuses
    });
", \yii\web\View::POS_END);
?>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>

</script>
