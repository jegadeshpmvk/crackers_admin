<?php

namespace app\modules\v1\controllers;

use Yii;
use yii\web\HttpException;
use yii\db\Expression;
use app\models\ShopSettings;
use app\models\Category;
use app\models\Product;
use app\models\Coupon;
use app\models\Order;
use app\models\OrderItems;
use app\models\Delivery;
use app\components\ApiController;
// use mikehaertl\wkhtmlto\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;

class PageController extends ApiController
{
    public function behaviors()
    {
        $b = parent::behaviors();
        $b['authenticator']['except'] = ['shop-settings', 'order-view', 'get-categories', 'get-products', 'confirm-order', 'get-deliveries', 'get-coupon'];
        $b['access']['except'] = ['shop-settings', 'order-view', 'get-categories', 'get-deliveries', 'confirm-order', 'get-products', 'get-coupon'];
        return $b;
    }

    public function actionShopSettings()
    {
        return ShopSettings::find()->active()->one();
    }

    public function actionGetCategories()
    {
        return Category::find()->active()->all();
    }

    public function actionGetDeliveries()
    {
        return Delivery::find()->active()->all();
    }


    public function actionGetProducts()
    {
        $search = Yii::$app->request->get('search', "");
        $catId  = Yii::$app->request->get('cat_id', "");
        $sort   = Yii::$app->request->get('sort', "");
        $query = Product::find()->active();

        if (!empty($search)) {
            $query->andFilterWhere(['like', 'name', $search]);
        }

        if (!empty($catId)) {
            $query->andFilterWhere(['category_id' => $catId]);
        }

        if ($sort == "low_to_high") {
            $query->orderBy(['price' => SORT_ASC]);
        } elseif ($sort == "high_to_low") {
            $query->orderBy(['price' => SORT_DESC]);
        } elseif ($sort == "latest") {
            $query->orderBy(new Expression("
            CAST(REGEXP_SUBSTR(alignment, '^[0-9]+') AS UNSIGNED) ASC,
            REGEXP_SUBSTR(alignment, '[A-Za-z]+$') ASC
        "));
        }

        return $query->all();
    }

    public function actionGetCoupon()
    {
        $code = Yii::$app->request->post('code', "");
        $query = Coupon::find()->active();

        if (!empty($code)) {
            $query->andFilterWhere(['code' => $code]);
        }

        return $query->one();
    }

    public function actionConfirmOrder()
    {
        $request = Yii::$app->request;

        // ✅ Decode cart properly
        $cartJson = $request->post('cart', '[]');
        $cart = json_decode($cartJson, true);

        if (empty($cart)) {
            return $this->asJson([
                'status' => false,
                'message' => 'Cart is empty or invalid'
            ]);
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            // ✅ Create Order
            $order = new Order();
            $order->order_id = "ORD-" . mt_rand(100000, 999999) . "-" . mt_rand(10, 99);
            $order->date = strtotime(date('Y-m-d H:i:s'));
            $order->customer_name = $request->post('customer_name');
            $order->phone = $request->post('number');
            $order->whatsapp = $request->post('whatsapp');
            $order->email = $request->post('email');
            $order->address = $request->post('address');
            $order->state = $request->post('state');
            $order->total = $request->post('total');
            $order->final_total = $request->post('final_total');
            $order->packing_charge = $request->post('packing_charge', 0);
            $order->promotion_discount = $request->post('promotion_discount', 0);
            $order->promotion_discount_id = $request->post('promotion_discount_id', 0);
            $order->order_status = 1;

            if (!$order->save()) {
                throw new \Exception("Order Save Failed: " . json_encode($order->errors));
            }

            $orderId = $order->id;

            // ✅ Save Order Items
            foreach ($cart as $item) {

                $orderItem = new OrderItems();
                $orderItem->order_id = $orderId;
                $orderItem->product_id = $item['id'];
                $orderItem->product_name = $item['name'];
                $orderItem->mrp = $item['mrp'];
                $orderItem->price = $item['price'];
                $orderItem->quantity = $item['qty'];
                $orderItem->total_price = $item['total_price'];

                if (!$orderItem->save()) {
                    throw new \Exception("Order Item Save Failed: " . json_encode($orderItem->errors));
                }
            }

            // ✅ Commit Transaction
            $transaction->commit();

            // ✅ Run PDF generation safely
            // $this->runPdfCron($orderId);

            return $this->asJson([
                'status' => true,
                'message' => 'Order Confirmed Successfully',
                'order_id' => $order->order_id
            ]);
        } catch (\Throwable $e) {
            $transaction->rollBack();
            return $this->asJson([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function actionOrderView($id)
    {

        $order = Order::find()->where(['order_id' => $id])->one();
        // print_r($order);
        // exit;
        $settings = ShopSettings::find()->active()->one();
        $file = $this->runPdfCronAsync($id);
        $content = $this->renderPartial('order-confirm', [
            'order' => $order,
            'settings' => $settings
        ]);



        return $this->asJson([
            'status' => 200,
            'content' => $content,
            'file' => $file
        ]);
    }

    public function runPdfCronAsync($id)
    {
        // $yiiPath = Yii::getAlias('@webroot') . '/yii';
        // $logPath = Yii::getAlias('@webroot') . '/cron.log';
        // //echo ini_get('disable_functions');exit;

        // $cmd = "php $yiiPath cron/pdf $id >> $logPath 2>&1 &";
        // \exec($cmd);

        //  echo "Pdf generation process started :: " . date('d/m/Y H:i:s A') . "\n\n";

        $order = Order::find()->where(['order_id' => $id])->one();
        $settings = ShopSettings::find()->active()->one();

        /* ==============================
         * Render HTML View File
         * ============================== */

        $viewFile = Yii::getAlias('@app/views/page/order-confirm-pdf.php');

        $html = Yii::$app->view->renderFile($viewFile, [
            'order' => $order,
            'settings' => $settings,
        ]);

        /* ==============================
         * DomPDF Setup
         * ============================== */

        $options = new Options();
        $options->set('isRemoteEnabled', true); // allow images, css from URL

        $dompdf = new Dompdf($options);

        /* Load HTML Content */
        $dompdf->loadHtml($html);

        /* Set Paper Size */
        $dompdf->setPaper('A4', 'portrait');

        /* Render PDF */
        $dompdf->render();

        /* ==============================
         * Save PDF File
         * ============================== */

        $file = Yii::getAlias('@webroot') . "/media/files/order/order_" . $order->order_id . ".pdf";

        file_put_contents($file, $dompdf->output());

        return Yii::getAlias('@baseUrl') . "/download-order?file=order_" . $order->order_id . ".pdf";

        // echo "PDF Generated Successfully: " . $file;
    }
}
