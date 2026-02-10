<?php

namespace app\modules\admin\models;

use Yii;

use yii\data\ActiveDataProvider;
use app\models\Product;

class ProductSearch extends Product
{

    public function rules()
    {
        return [
            [['name', 'tamil_name'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => Yii::$app->admin->identity->getCookie('list_total')]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'tamil_name', $this->tamil_name]);

       

        return $dataProvider;
    }
}
