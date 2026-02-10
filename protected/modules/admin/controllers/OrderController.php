<?php

namespace app\modules\admin\controllers;

use app\models\Order;
use app\modules\admin\components\Controller;
use app\modules\admin\models\OrderSearch;
use Yii;
use yii\web\NotFoundHttpException;

class OrderController extends Controller
{

    public $tab = "order";

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
        $cells[] = ["Id", "Name", "Discount",  "Created at"];

        $Order = Order::find()->select(['id'])->all();
        if (count($Order) > 0) {
            foreach (Order::find()->each(10) as $m) {
                $createdAt = $m->created_at != "" ? date("M d, Y g:i:s A", $m->created_at) : "";

                $arr = [];
                $arr[] = $m->id;
                $arr[] = $m->name;
                $arr[] = $m->discount;
                $arr[] = $createdAt;
                $cells[] = $arr;
            }
        }
        $fname = 'Order_' . date('d_m_Y_H_i_s');
        Yii::$app->function->createSpreadSheet($cells, $fname, false);
    }
}
