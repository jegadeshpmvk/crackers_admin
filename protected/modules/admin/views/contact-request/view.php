<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

function printData($data) {
    $temp = "";
    if ($data != "") {
        $temp = "<div style='word-break: break-all;'";
        foreach ($data as $key => $value) {
            $temp .= '<b>' . $key . ': </b>' . $value . "<br />";
        }
        $temp .= '</div>';
    }
    return $temp . '</div>';
}
?>
<h1 class="p-tl">Contact: <?= $model->name ?></h1>
<div class="options">
    <?= Html::a('Back to List', ['index'], ['class' => 'fa fa-list']) ?>
</div>
<div class="grid-view detail-view">
    <?=
    DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => 'N/A'],
        'attributes' => [
            'name',
            'email:email',
            'phone_number',
            [
                'label' => 'Message',
                'value' => nl2br(strip_tags($model->message))
            ],
            'created_at:datetime',
            [
                'label' => 'Contact Person Details',
                'value' => printData(json_decode($model->json, true)),
                'format' => 'raw'
            ],
        ],
    ])
    ?>
</div>
