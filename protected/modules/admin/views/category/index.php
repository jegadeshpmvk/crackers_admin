<?php

use yii\helpers\Html;
use app\extended\GridView;
?>
<div class="options">
    <?= Html::a('<span>Export as Excel</span>', ['export-excel'], ['class' => 'fa fa-table', 'target' => '_blank']) ?>
    <?= Html::a('<span>Import as Excel</span>', ['#'], ['class' => 'fa fa-table import_model', 'data-title' => 'Import Category Details',]) ?>

    <?= Html::a('Add New Category', ['category/create'], ['class' => 'fa fa-plus']) ?>
    <?= Html::a('<span>Search</span>', NULL, ['class' => 'fa fa-search']) ?>
    <?= Html::a('<span>Multi Delete</span>', NULL, ['class' => 'fa fa-trash multi_delete']) ?>
</div>
<h1 class="p-tl">Category</h1>
<?=
GridView::widget([
    'id' => 'category-grid',
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\CheckboxColumn',
            'contentOptions' => ['class' => 'grid-actions custom_checkbox']
        ],
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
            'template' => '{update}{delete}{enable}',
            'contentOptions' => ['class' => 'grid-actions']
        ]
    ],
]);
?>
<?= $this->render('_search', ['model' => $searchModel]) ?>
<?= $this->render('_import') ?>

<?php
$this->registerJs("
    $('.multi_delete').click(function(){
        var ids = $('#category-grid').yiiGridView('getSelectedRows');
        if(ids.length > 0){
            if(confirm('Are you sure you want to delete the selected items?')){
                $.post('" . \yii\helpers\Url::to(['multi-delete']) . "', {ids: ids}, function(data){
                    if(data.status == 200){
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                }, 'json');
            }
        } else {
            alert('Please select at least one item.');
        }
    });
");
?>