<?php

use yii\helpers\Html;
use app\extended\GridView;
?>
<div class="options">
    <?= Html::a('<span>Export as Excel</span>', ['export-excel'], ['class' => 'fa fa-table', 'target' => '_blank']) ?>
    <?= Html::a('<span>Import as Excel</span>', ['#'], ['class' => 'fa fa-table import_model', 'data-title' => 'Import Category Details',]) ?>

    <?= Html::a('Add New Category', ['category/create'], ['class' => 'fa fa-plus']) ?>
    <?= Html::a('<span>Search</span>', NULL, ['class' => 'fa fa-search']) ?>
    <?= Html::a('<span>Sort</span>', ['default/order', 'name' => 'Category'], ['class' => 'fa fa-reorder btn']) ?>
</div>
<h1 class="p-tl">Category</h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'name'
        ],
        [
            'attribute' => 'discount'
        ],
        [
            'attribute' => 'alignment'
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