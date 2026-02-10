<?php

use yii\helpers\Html;
use app\extended\GridView;
?>
<div class="options">

</div>
<div class="dashboard_header">
    <h1 class="p-tl">Dashboard</h1>
    <div class="dashboard_buttons">
        <?= Html::a('<span>Export Report</span>', ['export-excel'], ['class' => 'fa fa-download custom_button', 'target' => '_blank']) ?>
        <?= Html::a('<span>Add Product</span>', ['product/create'], ['class' => 'fa fa-plus blue custom_button']) ?>
    </div>

</div>
<div class="dashboard_grids">
    <div class="dashboard_grid">
        <div class="dashboard_grid_inner">
            <h4 class="grid_title">Total Revenue <i class="fa fa-credit-card"></i></h4>
            <div class="grid_amount">$24,158 <span></span></div>
            <h4 class="grid_title">From 32 Orders</h4>
        </div>
    </div>
    <div class="dashboard_grid">
        <div class="dashboard_grid_inner">
            <h4 class="grid_title">Total Revenue <i class="fa fa-credit-card"></i></h4>
            <div class="grid_amount">$24,158 <span></span></div>
            <h4 class="grid_title">From 32 Orders</h4>
        </div>
    </div>
    <div class="dashboard_grid">
        <div class="dashboard_grid_inner">
            <h4 class="grid_title">Total Revenue <i class="fa fa-credit-card"></i></h4>
            <div class="grid_amount">$24,158 <span></span></div>
            <h4 class="grid_title">From 32 Orders</h4>
        </div>
    </div>
    <div class="dashboard_grid">
        <div class="dashboard_grid_inner">
            <h4 class="grid_title">Total Revenue <i class="fa fa-credit-card"></i></h4>
            <div class="grid_amount">$24,158 <span></span></div>
            <h4 class="grid_title">From 32 Orders</h4>
        </div>
    </div>
</div>

<div class="dashboard_chats">
    <div class="sales_order">
        <div class="dashboard_grid_inner">
            <h4 class="grid_title">Total Revenue </h4>
            <div class="" id="lineChart"></div>
        </div>
    </div>
    <div class="categories">
        <div class="dashboard_grid_inner">
            <h4 class="grid_title">Top Categories</h4>
        </div>
    </div>
</div>

<div class="dashboard_chats">
    <div class="sales_order">
        <div class="dashboard_grid_inner">
            <h4 class="grid_title">Recent Orders </h4>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'order_id',
                        'label' => 'Order No'
                    ],
                    [
                        'attribute' => 'customer_name',
                        'label' => 'Customer Name'
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Date',
                        'format' => ['date', 'php:d F Y H:i:s a']
                    ],
                    [
                        'attribute' => 'final_total',
                        'label' => 'Total'
                    ],
                    [
                        'attribute' => 'order_status',
                        'label' => 'Status'
                    ],

                    [
                        'class' => 'app\extended\ActionColumn',
                        'contentOptions' => ['class' => 'grid-actions']
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <div class="categories">
        <div class="dashboard_grid_inner">
            <h4 class="grid_title">Best Selling Product</h4>
        </div>
    </div>
</div>