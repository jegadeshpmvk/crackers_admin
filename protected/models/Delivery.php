<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


class Delivery extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%delivery}}';
    }

    public function rules()
    {
        $rules = [
            [['name', 'packing_charges',  'min_order'], 'required']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }
}
