<?php

namespace app\modules\admin\controllers;

use app\models\Product;
use app\models\Order;
use app\models\Category;
use app\modules\admin\components\Controller;
use yii\data\ActiveDataProvider;


class DashboardController extends Controller
{

    public $tab = "dashboard";

    public function behaviors()
    {
        return require __DIR__ . '/../filters/LoginCheck.php';
    }

    public function actionIndex()
    {
        $product = Product::find()->active()->count();
        $totalAmount  = Order::find()->active()->sum('final_total');
        $order  = Order::find()->active()->count();
        $todayAmount  = Order::find()->active()->sum('final_total');
        $todayOrder  = Order::find()->active()->andWhere(['between', 'created_at', strtotime("today"), strtotime("tomorrow") - 1])->count();
        $latestOrder = new ActiveDataProvider([
            'query' => Order::find()->active()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['defaultPageSize' => 10]
        ]);

        $latestCategory = new ActiveDataProvider([
            'query' => Category::find()->active(),
            'pagination' => ['defaultPageSize' => 5]
        ]);

        for ($i = 29; $i >= 0; $i--) {
            $start = strtotime("-$i days midnight");
            $end   = strtotime("-$i days 23:59:59");

            $count = Order::find()
                ->active()
                ->andWhere(['between', 'created_at', $start, $end])
                ->count();

            $days[] = date("Y-m-d", $start);   // Like screenshot
            $orderCounts[] = (int)$count;
        }

        return $this->render('index', [
            'product' => $product,
            'totalAmount' => $totalAmount,
            'order' => $order,
            'todayAmount' => $todayAmount,
            'todayOrder' => $todayOrder,
            'latestOrder' => $latestOrder,
            'latestCategory' => $latestCategory,
            'days' => json_encode($days),
            'orderCounts' => json_encode($orderCounts),
        ]);
    }
}
