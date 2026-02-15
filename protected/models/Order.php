<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


class Order extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%order}}';
    }


    public function rules()
    {
        $rules = [
            [[
                'order_id',
                'date',
                'customer_name',
                'phone',
                'whatsapp',
                'email',
                'address',
                'refer',
                'state',
                'total',
                'packing_charge',
                'promotion_discount',
                'promotion_discount_id',
                'final_total',
                'order_status'
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

    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::className(), ['order_id' => 'id']);
    }

    public function getOrderStatus()
    {
        return  [
            1 => 'Order Received',
            2 => 'AMT Pending',
            3 => 'Amt Received',
            4 => 'Packing',
            5 => 'Delivered',
            6 => 'Cancelled',
        ];
    }

    public function getOrderSingleStatus($status)
    {
        $statuses = $this->getOrderStatus();

        // ✅ Safe return (avoid undefined index error)
        return $statuses[$status] ?? 'Unknown Status';
    }
}
