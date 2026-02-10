<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


class Product extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%product}}';
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
            [['category_id', 'name', 'tamil_name', 'price', 'mrp', 'type', 'alignment', 'code'], 'required'],
            [['video_url',  'image_ids'], 'safe'],
            [['alignment', 'code'], 'unique']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function fields()
    {
        $fields = [
            'id' => 'id',
            'name' => 'name',
            'tamil_name' => 'tamil_name',
            'price' => 'price',
            'category' => 'category',
            'mrp' => 'mrp',
            'type' => 'type',
            'alignment' => 'alignment',
            'images' => 'images',
        ];
        return ArrayHelper::merge($fields);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function beforeSave($insert)
    {
        $this->image_ids = json_encode($this->image_ids);
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if ($this->image_ids) {
            $this->image_ids = json_decode($this->image_ids, true);
        }
    }

    public function getImages()
    {
        return $this->hasMany(Media::className(), ['id' => 'image_ids']);
    }
}
