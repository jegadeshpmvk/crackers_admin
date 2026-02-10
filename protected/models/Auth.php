<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class Auth extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%auth}}';
    }

    public function rules()
    {
        $rules = [
            [['user_id', 'source', 'source_id'], 'required']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'user_id']);
    }
}
