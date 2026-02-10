<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


class Category extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%category}}';
    }

    public static function find()
    {
        // Parent find() returns the custom Scope
        $query = parent::find();

        // Apply complex ORDER BY on 'name'
        $query->orderBy(new Expression("
            CAST(REGEXP_SUBSTR(alignment, '^[0-9]+') AS UNSIGNED) ASC,
            REGEXP_SUBSTR(alignment, '[A-Za-z]+$') ASC
        "));

        return $query;
    }

    public function rules()
    {
        $rules = [
            [['name', 'discount', 'alignment'], 'required'],
            [['order'], 'safe'],
            [['alignment'], 'unique']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    // public function beforeSave($insert) {
    //     if ($this->isNewRecord) {
    //         $this->json = json_encode($_SERVER);
    //     }
    //     return parent::beforeSave($insert);
    // }

}
