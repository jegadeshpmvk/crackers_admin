<?php

namespace app\controllers;

use app\components\Controller;


class SiteController extends Controller
{

    public function actionIndex()
    {

        return $this->render('index', [
            'page' => 'Home',
        ]);
    }
    
    public function actionDownloadOrder($file)
    {
        $path = Yii::getAlias('@webroot') . "/media/files/order/" . $file;
    
        if (!file_exists($path)) {
            throw new \yii\web\NotFoundHttpException("File not found");
        }
    
        return Yii::$app->response->sendFile($path, $file, [
            'inline' => false, // ✅ Force download, not open
        ]);
    }
}
