<?php

namespace app\modules\admin\controllers;

use app\models\Order;
use app\modules\admin\components\Controller;
use app\modules\admin\models\ReportSearch;
use Yii;
use yii\web\NotFoundHttpException;

class ReportController extends Controller
{

    public $tab = "report";

    public function behaviors()
    {
        return require __DIR__ . '/../filters/LoginCheck.php';
    }

    public function actionIndex()
    {
        $searchModel = new ReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function renderForm($model)
    {
        return $this->render('_form', [
            'model' => $model
        ]);
    }

    public function actionDelete($id, $value)
    {
        $model = $this->findModel($id);
        $model->deleted = (int) $value;
        if ($value == 1) {
            $model->saveType = 'deleted';
        } else {
            $model->saveType = 'restored';
        }
        $model->save(false);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The request page does not exist.');
        }
    }

    public function actionExportExcel()
    {
        $cells[] = ["S.No", "Name", "Number", "Address Value", "Order Value", "Created at"];

        $Category = Order::find()->select(['id'])->all();
        if (count($Category) > 0) {
            foreach (Order::find()->each(10) as $k => $m) {
                $createdAt = $m->created_at != "" ? date("M d, Y g:i:s A", $m->created_at) : "";

                $arr = [];
                $arr[] = (int) ($k + 1);
                $arr[] = $m->customer_name;
                $arr[] = $m->phone;
                $arr[] = $m->address;
                $arr[] = $m->final_total;
                $arr[] = $createdAt;
                $cells[] = $arr;
            }
        }
        $fname = 'Report_' . date('d_m_Y_H_i_s');
        Yii::$app->function->createSpreadSheet($cells, $fname, false);
    }
}
