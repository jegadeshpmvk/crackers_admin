<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class Admin extends User
{

    public function init()
    {
        $this->type = self::TYPE_ADMIN;
    }

    public static function find()
    {
        $find = parent::find();
        return $find->andWhere(['type' => self::TYPE_ADMIN]);
    }

    public function rules()
    {
        $rules = [
            [['role'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

   


}
