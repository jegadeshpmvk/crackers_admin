<?php

use yii\helpers\Html;
use app\extended\GridView;
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
            'format' => ['date', 'php:d F Y H:i:s a'],
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
            'label' => 'Amount'
        ],
        [
            'attribute' => 'order_status',
            'label' => 'Status'
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:d F Y H:i:s a']
        ],
        [
            'class' => 'app\extended\ActionColumn',
            'contentOptions' => ['class' => 'grid-actions']
        ],
    ],
]);
?>
<?= $this->render('_search', ['model' => $searchModel]) ?>