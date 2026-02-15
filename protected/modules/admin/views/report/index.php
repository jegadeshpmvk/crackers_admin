<?php

use yii\helpers\Html;
use app\extended\GridView;
?>
<div class="options">
    <?= Html::a('<span>Export as Excel</span>', ['export-excel'], ['class' => 'fa fa-table', 'target' => '_blank']) ?>
    <?= Html::a('<span>Search</span>', NULL, ['class' => 'fa fa-search']) ?>
</div>
<h1 class="p-tl">Reports</h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'header' => 'S.No',
        ],
        [
            'attribute' => 'customer_name',
            'label' => 'Name'
        ],
        [
            'attribute' => 'phone',
            'label' => 'Number'
        ],
        [
            'attribute' => 'address',
            'label' => 'Address Value'
        ],
        [
            'attribute' => 'final_total',
            'label' => 'Order Value',
            'value' => function ($model) {
                return Yii::$app->formatter->asCurrency($model->final_total, 'INR');
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:d F Y H:i:s a'],
            'label' => 'Date'
        ],
    ],
]);
?>
<?= $this->render('_search', ['model' => $searchModel]) ?>