<?php

namespace app\components;

use Yii;
use yii\web\Response;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;

class ApiController extends \yii\rest\Controller
{
    public $_user = false;

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => HttpBearerAuth::className(),
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $this->_user = Yii::$app->user->identity;
                            $_POST['logged_in_user'] = $this->_user->id;
                            return true;
                        }
                    ]
                ],
            ]
        ];
    }

    public function beforeAction($action)
    {
        //Set response type as JSON
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            throw new HttpException(204, 'Options request');
            exit;
        }

        return parent::beforeAction($action);
    }

    public function assignFields($list, $type = "POST")
    {
        $data = [];

        if ($type === "POST" && Yii::$app->request->isPost) {
            foreach ($list as $l) {
                $val = Yii::$app->request->post($l, "");
                if (is_string($val))
                    $val = trim($val);
                $data[$l] = $val;
            }
        } else if ($type === "PATCH") {
            foreach ($list as $l) {
                $val = @Yii::$app->request->getBodyParam($l);
                if (is_string($val))
                    $val = trim($val);
                $data[$l] = $val;
            }
        }
        return $data;
    }

    public function validationError($model)
    {
        Yii::$app->response->statusCode = 400;
        return ActiveForm::validate($model);
    }
}
