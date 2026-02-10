<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class Customer extends User
{

    public function init()
    {
        $this->type = self::TYPE_CUSTOMER;
    }

    public static function find()
    {
        $find = parent::find();
        return $find->andWhere(['type' => self::TYPE_CUSTOMER]);
    }

    public function rules()
    {
        $rules = [
            [['fullname'], 'required'],
            [['countryId', 'stateId', 'cityId', 'profile_img', 'current_plan', 'plan_expires', 'customer', 'mobile_number'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function attributeLabels()
    {
        $labels = [
            'fullname' => 'Full Name'
        ];
        return ArrayHelper::merge(parent::attributeLabels(), $labels);
    }

    public function getProfileImage()
    {
        return $this->hasOne(Media::className(), ['id' => 'profile_img']);
    }
}
