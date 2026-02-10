<?php

namespace app\extended;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn {

    public $template = '{update} {delete} {restore} <div class="full-row-click">{view}</div>';
    public $urlprefix = "";

    protected function initDefaultButtons() {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                return Html::a('Update', Url::to([$this->urlprefix . 'update', 'id' => (string) $key]), [
                            'class' => 'full-row-edit update-tr',
                            'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a($this->toolTip('Update'), Url::to([$this->urlprefix . 'update', 'id' => (string) $key]), [
                            'title' => 'Update',
                            'class' => 'fa fa-pencil-square-o  update-tr',
                            'data-pjax' => '0',
                ]);
            };
        }


        if (!isset($this->buttons['duplicate'])) {
            $this->buttons['duplicate'] = function ($url, $model, $key) {
                return Html::a($this->toolTip('Duplicate'), Url::to([$this->urlprefix . 'duplicate', 'id' => (string) $key]), [
                            'title' => 'Duplicate',
                            'class' => 'fa fa-copy',
                            'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                return Html::a($this->toolTip('Delete'), Url::to([$this->urlprefix . 'delete', 'id' => (string) $key]), [
                            'title' => 'Delete',
                            'class' => 'fa fa-trash-o',
                            'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['remove'])) {
            $this->buttons['remove'] = function ($url, $model, $key) {
                return Html::a($this->toolTip('Remove'), Url::to([$this->urlprefix . 'remove', 'id' => (string) $key]), [
                            'title' => 'Remove',
                            'class' => 'fa fa-times-circle',
                            'data-pjax' => '0',
                ]);
            };
        }
        if (!isset($this->buttons['restore'])) {
            $this->buttons['restore'] = function ($url, $model, $key) {
                return Html::a($this->toolTip('Restore'), Url::to([$this->urlprefix . 'restore', 'id' => (string) $key]), [
                            'title' => 'Restore',
                            'class' => 'fa fa-recycle',
                            'data-pjax' => '0',
                ]);
            };
        }
    }

    protected function toolTip($text) {
        return '<span class="tool-tip"><span class="center">' . $text . '</span></span>';
    }

}
