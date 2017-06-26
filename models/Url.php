<?php

namespace app\models;

use Yii;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;

/**
 * This is the model class for table "url".
 *
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property integer $status_code
 * @property integer $created_at
 * @property integer $updated_at
 */
class Url extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'title'], 'required'],
            [['status_code', 'created_at', 'updated_at'], 'integer'],
            [['url', 'title'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'title' => 'Title',
            'status_code' => 'Status Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function populate()
    {
        $client = new Client();
        $client->setTransport(new CurlTransport);
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl($this->url)
            ->send();

        $this->setTitle($response->getContent());
        $this->status_code = $response->getStatusCode();
    }

    public function setTitle($content)
    {

        preg_match('#<title>(.*)</title>#', $content, $title);

        $this->title = $title[1] ?? null;
    }
}
