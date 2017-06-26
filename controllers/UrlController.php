<?php

namespace app\controllers;

use app\models\Url;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class UrlController extends \yii\web\Controller
{
    public function actionList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Url::find(),
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSend()
    {
        \Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        $model = new Url();
        $getParams = \Yii::$app->getRequest()->get();
        if (isset($getParams['url'])) {
            $model->url = $getParams['url'];
            $model->populate();
            $model->save(false);
        }

        return $model->getAttributes();
    }

    public function actionViewStat($id)
    {
        $model = Url::findOne(['id' => $id]);

        $data = Url::find()->where(['url' => $model->url])->asArray()->all();

        $data = array_map(function ($array) {
            $array['created_at'] = date('Y-m-d', $array['created_at']);
            return $array;
        }, $data);

        $dates =  array_unique(array_column($data, 'created_at'));

        $statusDates = ArrayHelper::index($data, null, [function ($element) {
            return $element['status_code'];
        }, 'created_at']);

        foreach ($statusDates as $statusCode => $dateArray) {
            $statusDates[$statusCode]['name'] = $statusCode;
            foreach ($dateArray as $date => $items) {
                $statusDates[$statusCode]['data'][$date] = count($items);
                unset($statusDates[$statusCode][$date]);
            }
            $statusDates[$statusCode]['data'] = array_values($statusDates[$statusCode]['data']);
        }

        $statusDates = array_values($statusDates);

        return $this->render('view-stat', [
            'dates' => json_encode(array_values($dates)),
            'statuses' => json_encode($statusDates)
        ]);
    }

}
