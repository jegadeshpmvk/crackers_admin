<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Order;

class ReportSearch extends Order
{
    public $from_date;
    public $to_date;

    public function rules()
    {
        return [
            [['order_id', 'order_status', 'from_date', 'to_date', 'customer_name'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => Yii::$app->admin->identity->getCookie('list_total')]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'order_id', $this->order_id])
            ->andFilterWhere(['like', 'order_status', $this->order_status])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name]);
       
        if ($this->from_date && $this->to_date) {
            $query->andFilterWhere([
                'between',
                'created_at',
                strtotime($this->from_date . " 00:00:00"),
                strtotime($this->to_date . " 23:59:59"),
            ]);
        }

        return $dataProvider;
    }
}
