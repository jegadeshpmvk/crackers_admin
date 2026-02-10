<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/swiper-bundle.css',
        'css/datatables.min.css',
        'css/common.css',
        'css/font-awesome.css',
        'css/fonts.css',
        'css/jquery-ui.css',
        'css/editor.css',
         'css/heatmap.css',
        'css/stylesheet.css',
    ];
    public $js = [
        'js/dev/libs/jquery.viewportchecker.js',
        'js/dev/libs/isinviewport.js',
        'js/dev/libs/datatables.min.js',
        'js/dev/libs/jquery.history.js',
        'js/dev/libs/jquery.ajaxq.js',
        'js/dev/libs/jquery-ui.js',
        'js/dev/libs/chart.js',
        'js/dev/libs/gauge.js',
        'js/dev/libs/alertify.js',
        'js/dev/libs/jquery.fileupload.js',
        'js/dev/libs/jquery.matchHeight.js',
        'js/dev/libs/jquery.MCLoadImages.min.js',
        'js/dev/libs/swiper-bundle.js',
        'js/dev/libs/apexcharts.js',
        
        'js/dev/libs/d3.v3.min.js',
        'js/dev/libs/d3-queue.v3.min.js',
        
        'js/dev/utils/pageload.js',
        'js/dev/utils/scrollbar.js',
        'js/dev/utils/media.js',
        'js/dev/utils/jquery.extend.js',
        'js/dev/utils/browser.js',
        'js/dev/validation.js',
        'js/dev/script.js',
        'js/dev/heatmap.js'
    ];
    public $jsOptions = [
        'type' => 'text/javascript'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\grid\GridViewAsset',
    ];
}
