<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


class Coupon extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%coupon}}';
    }

    public function rules()
    {
        $rules = [
            [['name', 'code',  'discount'], 'required']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

}
