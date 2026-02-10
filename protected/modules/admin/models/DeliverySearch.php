<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\Delivery;

class DeliverySearch extends Delivery
{

    public function rules()
    {
        return [
            [['name', 'packing_charges', 'min_order'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Delivery::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => Yii::$app->admin->identity->getCookie('list_total')]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->packing_charges])
            ->andFilterWhere(['like', 'discount', $this->min_order]);

        return $dataProvider;
    }
}
