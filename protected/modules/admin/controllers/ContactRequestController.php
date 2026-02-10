<?php

namespace app\modules\admin\controllers;

use app\models\ContactRequest;
use app\modules\admin\components\Controller;
use app\modules\admin\models\ContactRequestSearch;
use Yii;
use yii\web\NotFoundHttpException;

class ContactRequestController extends Controller
{

    public $tab = "contact";

    public function behaviors()
    {
        return require __DIR__ . '/../filters/LoginCheck.php';
    }

    public function actionIndex()
    {
        $searchModel = new ContactRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function renderForm($model)
    {
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionUpdate($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = ContactRequest::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The request page does not exist.');
        }
    }

    public function actionExportExcel()
    {
        $cells[] = ["Name", "Email", "Phone Number", "Message", "Contacted at"];

        $contactRequests = ContactRequest::find()->select(['id'])->all();
        if (count($contactRequests) > 0) {
            foreach (ContactRequest::find()->each(10) as $m) {

                $createdAt = $m->created_at != "" ? date("M d, Y g:i:s A", $m->created_at) : "";

                $arr = [];
                $arr[] = $m->name;
                $arr[] = $m->email;
                $arr[] = $m->phone_number;
                $arr[] = strip_tags($m->message);
                $arr[] = $createdAt;
                $cells[] = $arr;
            }
        }
        $fname = 'contact_request_' . date('d_m_Y_H_i_s');
        Yii::$app->function->createSpreadSheet($cells, $fname, false);
    }
}
