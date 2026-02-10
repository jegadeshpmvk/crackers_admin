<?php

use yii\helpers\Html;
use app\extended\GridView;
?>
<div class="options">
    <?= Html::a('Add New Media', ['media/create'], ['class' => 'fa fa-plus']) ?>
    <?= Html::a('<span>Search</span>', NULL, ['class' => 'fa fa-search']) ?>
</div>
<h1 class="p-tl">Media</h1>
<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'id',
            'format' => 'text', // ensures it's plain text
            'value' => function ($model) {
                return $model->id; // plain number, no link
            },
        ],
        [
            'attribute' => 'type',
            'label' => 'Image',
            'format' => 'raw', // ensures it's plain text
            'value' => function ($model) {
                if ($model->type === 'image') {
                    if ($model->extension === 'svg')
                        return '<img width="150" height="150"  src="' . $model->url . '" />';
                    else
                        return '<img width="150" height="150"  src="' . $model->url["file"] . '" />';
                } else {
                    return '<img src="' . $model->url . '" />';
                }
            },
        ],
        [
            'attribute' => 'name'
        ],
        [
            'attribute' => 'orgname'
        ],
        [
            'attribute' => 'created_at',
            'format' => ['date', 'php:d F Y H:i:s a']
        ],

    ],
]);
?>
<?= $this->render('_search', ['model' => $searchModel]) ?>