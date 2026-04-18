<?php

namespace app\modules\admin\controllers;

use app\models\Order;
use app\models\OrderItems;
use app\models\Product;
use app\modules\admin\components\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class BillingController extends Controller
{
    public $tab = "billing";

    public function behaviors()
    {
        return require __DIR__ . '/../filters/LoginCheck.php';
    }

    public function actionCreate()
    {
        $model = new Order();
        return $this->render('create', ['model' => $model]);
    }

    // Select2 AJAX source for products
    public function actionProductSearch($q = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => []];
        if (!is_null($q)) {
            $query = Product::find()->where(['deleted' => 0])->andWhere(['like', 'name', $q])->limit(20)->all();
            foreach ($query as $p) {
                $out['results'][] = [
                    'id' => $p->id,
                    'text' => $p->name,
                    'price' => (float)$p->sellingPrice,
                    'mrp' => (float)$p->mrp,
                    'discount' => (float)($p->discount ?? 0),
                ];
            }
        }
        return $out;
    }

    // AJAX save for order + items
    public function actionAjaxSave()
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            return $this->asJson(['status' => 400, 'message' => 'Invalid request']);
        }
        $data = $request->post();
        $items = $data['items'] ?? [];
        if (is_string($items)) {
            $items = json_decode($items, true) ?: [];
        }

        // Server-side: ensure at least one item is provided
        if (empty($items) || !is_array($items) || count($items) === 0) {
            return $this->asJson([
                'status' => 400,
                'message' => 'At least one item is required',
            ]);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new Order();

            // generate order_id like ORD-<YEAR>-NN
            $year = date('Y');
            $lastOrder = Order::find()->where(['like', 'order_id', "ORD-$year-%", false])->orderBy(['id' => SORT_DESC])->one();
            if ($lastOrder && !empty($lastOrder->order_id)) {
                $parts = explode('-', $lastOrder->order_id);
                $lastNum = (int) end($parts);
                $newNumber = $lastNum + 1;
            } else {
                $newNumber = 1;
            }
            $model->order_id = "ORD-$year-" . str_pad($newNumber, 2, '0', STR_PAD_LEFT);

            // load posted attributes (no form name)
            $model->load($data, '');
            $now = time();
            $model->created_at = $now;
            // ensure `date` column is set (DB requires non-null)
            if (empty($model->date)) {
                $model->date = $now;
            }
            $model->updated_at = $now;
            $model->order_status = 1;

            // compute totals if not provided
            $total = 0;
            foreach ($items as $it) {
                $total += (float)($it['total_price'] ?? 0);
            }
            $model->total = $total;
            $model->final_total = $data['final_total'] ?? $total;

            // validate server-side and return structured errors if validation fails
            if (!$model->validate()) {
                $transaction->rollBack();
                return $this->asJson([
                    'status' => 400,
                    'message' => 'Validation failed',
                    'errors' => $model->getErrors(),
                ]);
            }

            if (!$model->save(false)) {
                throw new \Exception('Order Save Failed: ' . json_encode($model->getErrors()));
            }

            foreach ($items as $it) {
                $oi = new OrderItems();
                $oi->order_id = $model->id;
                $oi->product_id = $it['product_id'] ?? ($it['id'] ?? null);
                $oi->product_name = $it['product_name'] ?? ($it['name'] ?? '');
                $oi->mrp = $it['mrp'] ?? 0;
                $oi->price = $it['price'] ?? 0;
                $oi->quantity = $it['quantity'] ?? ($it['qty'] ?? 0);
                $oi->total_price = $it['total_price'] ?? 0;
                if (!$oi->save()) {
                    throw new \Exception('Order Item Save Failed: ' . json_encode($oi->getErrors()));
                }
            }

            $transaction->commit();

            // Attempt to generate PDF asynchronously/synchronously via v1 PageController helper
            try {
                $pageCtrl = new \app\modules\v1\controllers\PageController('page', Yii::$app->getModule('v1'));
                // PageController::runPdfCronAsync expects order_id (string like ORD-...)
                $pageCtrl->runPdfCronAsync($model->order_id);
            } catch (\Throwable $e) {
                // Log and continue; PDF generation failure shouldn't block order creation
                Yii::error('PDF generation failed for order ' . $model->order_id . ' - ' . $e->getMessage());
            }

            return $this->asJson(['status' => 200, 'message' => 'Order created', 'id' => $model->id, 'order_id' => $model->order_id]);
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return $this->asJson(['status' => 400, 'message' => $e->getMessage()]);
        }
    }
}
?>