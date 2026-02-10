<?php

namespace app\modules\v1;

class Module extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\v1\controllers';

    public function init() {
        parent::init();
        \Yii::$app->user->enableSession = false;
        \Yii::configure(\Yii::$app, [
            'components' => [
                'response' => [
                    'class' => 'yii\web\Response',
                    'on beforeSend' => function ($event) {
                        $response = $event->sender;
                        if ($response->data !== null) {
                            $status = $response->statusCode;
                            if (isset($response->data['status'])) {
                                $status = $response->data['status'];
                                unset($response->data['status']);
                            }
                            $response->data = [
                                'status' => $status,
                                'data' => $response->data,
                            ];
                            $response->statusCode = 200;
                        }
                    },
                ]
            ]
        ]);
    }

}
