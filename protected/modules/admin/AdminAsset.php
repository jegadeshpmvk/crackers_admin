<?php

namespace app\modules\admin;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{

    public $sourcePath = '@app/modules/admin/assets';
    public $css = [
        'css/common.css',
        'css/font-awesome.css',
        'css/editor.css',
        'css/form.css',
        'css/fileupload.css',
        'css/alertify.css',
        'css/dashicons.css',
        'css/template.css',
        'css/cropper.css',
        'css/select2.min.css',
        'css/stylesheet.css',
        'css/login.css',
        'css/toggle.css',
        'css/responsive.css'
    ];
    public $js = [
        'js/libs/modernizr.js',
        'js/libs/alertify.js',
        'js/libs/apexcharts.js',
        'js/libs/js.cookie.js',
        'js/libs/jquery.ajaxq.js',
        'js/libs/apexcharts.js',
        'js/libs/jquery.rowgrid.js',
        'js/libs/jquery.autosize.js',
        'js/libs/jquery.redactor.js',
        'js/libs/jquery.fileupload.js',
        'js/libs/select2/select2.full.min.js',
        'js/imagemanager.js',
        'js/block.js',
        'js/flexible.js',
        'js/script.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
    ];
    public $publishOptions = [
        'forceCopy'
        => true
    ];
}
