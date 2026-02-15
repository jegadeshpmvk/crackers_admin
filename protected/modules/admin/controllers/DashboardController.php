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
        $start = strtotime(date("Y-m-d 00:00:00")); // Today start
        $end   = strtotime(date("Y-m-d 23:59:59")); // Today end
        $todayAmount  = Order::find()->active()->andWhere(['>=', 'created_at', $start])
            ->andWhere(['<=', 'created_at', $end])->sum('final_total');

        $todayOrder = Order::find()
            ->active()
            ->andWhere(['>=', 'created_at', $start])
            ->andWhere(['<=', 'created_at', $end])
            ->count();
        // $todayOrder  = Order::find()->active()->andWhere(['between', 'created_at', $start, $end])->count();
        $latestOrder = new ActiveDataProvider([
            'query' => Order::find()->active()->orderBy(['created_at' => SORT_DESC])->limit(5),
            'pagination' => false
        ]);

        $latestCategory = new ActiveDataProvider([
            'query' => Category::find()->active()->limit(5),
            'pagination' => false
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
            'todayAmount' => $todayAmount || 0,
            'todayOrder' => $todayOrder || 0,
            'latestOrder' => $latestOrder,
            'latestCategory' => $latestCategory,
            'days' => json_encode($days),
            'orderCounts' => json_encode($orderCounts),
        ]);
    }
}
