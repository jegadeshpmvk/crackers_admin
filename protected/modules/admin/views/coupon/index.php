<?php

use yii\helpers\Html;
use app\extended\GridView;
?>
<div class="options">
    <?= Html::a('<span>Export as Excel</span>', ['export-excel'], ['class' => 'fa fa-table', 'target' => '_blank']) ?>
    <?= Html::a('<span>Import as Excel</span>', ['#'], ['class' => 'fa fa-table import_model', 'data-title' => 'Import Coupon Details',]) ?>

    <?= Html::a('Add New Coupon', ['coupon/create'], ['class' => 'fa fa-plus']) ?>
    <?= Html::a('<span>Search</span>', NULL, ['class' => 'fa fa-search']) ?>
</div>
<h1 class="p-tl">Coupon</h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'name',
            'label' => 'To Agent',
        ],
        [
            'attribute' => 'code',
            'label' => 'Promocode',
        ],
        [
            'attribute' => 'discount',
            'label' => 'Discount (%)',
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
<?= $this->render('_import') ?>