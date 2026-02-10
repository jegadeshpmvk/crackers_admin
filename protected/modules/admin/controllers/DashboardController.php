<?php

namespace app\modules\admin\controllers;

use app\models\ContactRequest;
use app\modules\admin\components\Controller;
use app\modules\admin\models\ContactRequestSearch;
use Yii;
use app\modules\admin\models\OrderSearch;

class DashboardController extends Controller
{

    public $tab = "dashboard";

    public function behaviors()
    {
        return require __DIR__ . '/../filters/LoginCheck.php';
    }

    public function actionIndex()
    {

        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
