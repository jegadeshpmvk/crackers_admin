<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


class OrderItems extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%order-items}}';
    }


    public function rules()
    {
        $rules = [
            [[
                'order_id',
                'product_id',
                'product_name',
                'mrp',
                'code',
                'price',
                'quantity',
                'total_price'
            ], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    // public function beforeSave($insert) {
    //     if ($this->isNewRecord) {
    //         $this->json = json_encode($_SERVER);
    //     }
    //     return parent::beforeSave($insert);
    // }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
