<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\ActiveDataProvider;
use app\models\ContactRequest;

class ContactRequestSearch extends ContactRequest {

    public function rules() {
        return [
            [['name', 'email', 'phone_number'], 'safe'],
        ];
    }

    public function search($params) {
        $query = ContactRequest::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['defaultPageSize' => Yii::$app->admin->identity->getCookie('list_total')]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'phone', $this->phone_number]);

        return $dataProvider;
    }

}
