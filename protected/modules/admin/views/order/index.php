<?php

use Yii;
use yii\helpers\Html;
use app\extended\GridView;
use yii\helpers\Url;


?>
<div class="options">
    <?= Html::a('<span>Export as Excel</span>', ['export-excel'], ['class' => 'fa fa-table', 'target' => '_blank']) ?>
    <?= Html::a('<span>Search</span>', NULL, ['class' => 'fa fa-search']) ?>
</div>
<h1 class="p-tl">Order</h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'header' => 'S.No',
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:Y-m-d'],
            'label' => 'Date'
        ],
        [
            'attribute' => 'order_id',
            'label' => 'Order No'
        ],
        [
            'attribute' => 'customer_name',
            'label' => 'Customer Name'
        ],
        [
            'attribute' => 'phone',
            'label' => 'Customer Number'
        ],
        [
            'attribute' => 'address',
            'label' => 'Customer Address'
        ],
        [
            'attribute' => 'final_total',
            'label' => 'Amount',
            'value' => function ($model) {
                return Yii::$app->formatter->asCurrency($model->final_total, 'INR');
            }
        ],
        [
            'attribute' => 'order_status',
            'label' => 'Status',
            'format' => 'raw',
            'value' => function ($model) {
                $moduleId = Yii::$app->controller->module->id;
                $controllerId = Yii::$app->controller->id;
                $urlprefix = "/$moduleId/$controllerId/";
                return Html::dropDownList(
                    'order_status',
                    (int)$model->order_status,
                    [
                        1 => 'Order Received',
                        2 => 'AMT Pending',
                        3 => 'Amt Received',
                        4 => 'Packing',
                        5 => 'Delivered',
                        6 => 'Cancelled',
                    ],
                    [
                        'class' => 'form-control',
                        'data-id' => $model->id,
                        'data-url' => Url::to([$urlprefix . 'status-update'])
                    ]
                );
            },
        ],
        [
            'class' => 'app\extended\ActionColumn',
            'template' => '{order_view}',
            'contentOptions' => ['class' => 'grid-actions']
        ]
    ],
]);
?>
<?= $this->render('_search', ['model' => $searchModel]) ?>