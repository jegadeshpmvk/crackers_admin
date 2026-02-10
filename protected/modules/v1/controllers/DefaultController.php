<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\helpers\Html;
use app\components\ApiController;

class DefaultController extends ApiController
{

    public function behaviors()
    {
        return [];
    }

    public function actionError()
    {
        header('Content-type: application/json');
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            echo json_encode([
                "status" => $exception->statusCode,
                "name" => Html::encode($exception->getMessage())
            ]);
            exit();
        }
        echo json_encode([
            "status" => 404,
            "name" => "The requested page does not exist."
        ]);
        exit();
    }
}
