<?php
/* @var $this yii\web\View */
use yii\grid\GridView;

$this->title = 'Urls';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',

        [
            'label'=>'Url',
            'format' => 'raw',
            'value'=>function ($data) {
                return \yii\helpers\Html::a($data->url, Yii::$app->getUrlManager()->createUrl(['url/view-stat', 'id' => $data->id]));
            },
        ],
        'title',
        'status_code',
        'created_at:datetime',
    ],
]); ?>