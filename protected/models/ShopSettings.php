<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class ShopSettings extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%shop-settings}}';
    }

    public function rules()
    {
        $rules = [
            [['copyrights', 'shop_name', 'shop_code', 'min_order', 'bill_discount'], 'required'],
            [[
                'header_menu',
                'footer_menu',
                'text',
                'email',
                'social_media',
                'bank_details',
                'logo_id',
                'banner_ids',
                'whatsapp_number',
                'mobile_number',
                'alternate_mobile_mumber',
                'email_id',
                'google_map_loaction',
                'google_map_embeed',
                'address',
                'gst_no'
            ], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function beforeSave($insert)
    {
        $this->header_menu = json_encode($this->header_menu);
        $this->footer_menu = json_encode($this->footer_menu);
        $this->social_media = json_encode($this->social_media);
        $this->bank_details = json_encode($this->bank_details);
        $this->banner_ids = json_encode($this->banner_ids);
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->header_menu = json_decode($this->header_menu, true);
        $this->footer_menu = json_decode($this->footer_menu, true);
        $this->social_media = json_decode($this->social_media, true);
        if ($this->bank_details) {
            $this->bank_details = json_decode($this->bank_details, true);
        }
        if ($this->banner_ids) {
            $this->banner_ids = json_decode($this->banner_ids, true);
        }
    }

    public function getSocial()
    {
        return [
            "fa fa-facebook" => "Facebook",
            "fa fa-twitter" => "Twitter",
            "fa fa-instagram" => "Instagram",
            "fa fa-linkedin" => "Linkedin",
            "fa fa-youtube" => "Youtube",
            "fa fa-telegram"  => "Telegram"
        ];
    }

    public function getLogo()
    {
        return $this->hasOne(Media::className(), ['id' => 'logo_id']);
    }

    public function getBannerImages()
    {
        return $this->hasMany(Media::className(), ['id' => 'banner_ids']);
    }
}
