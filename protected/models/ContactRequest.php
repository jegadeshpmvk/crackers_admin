<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


class ContactRequest extends ActiveRecord {

    public static function tableName() {
        return '{{%contact-us}}';
    }

    public function rules() {
        $rules = [
            [['name', 'email', 'phone_number'], 'required'],
            [['name', 'email', 'phone_number', 'message'], 'safe'],
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->json = json_encode($_SERVER);
        }
        return parent::beforeSave($insert);
    }

}
