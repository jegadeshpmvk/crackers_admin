<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<div class="search-form">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    ?>
    <?=
    $form->field($model, 'from_date', ['options' => ['class' => 'form-group datepicker_icon']])->widget(\yii\jui\DatePicker::classname(), [
        'options' => ['placeholder' => 'From Date', 'autocomplete' => 'off'],
        'dateFormat' => 'php:d/m/Y',
        'class' => 'form-control',
    ])->label('');
    ?>
    <?=
    $form->field($model, 'to_date', ['options' => ['class' => 'form-group datepicker_icon']])->widget(\yii\jui\DatePicker::classname(), [
        'options' => ['placeholder' => 'To Date', 'autocomplete' => 'off'],
        'dateFormat' => 'php:d/m/Y',
        'class' => 'form-control',
    ])->label('');
    ?>
    <?= $form->field($model, 'order_status')
        ->dropDownList([
            1 => 'Order Received',
            2 => 'AMT Pending',
            3 => 'Amt Received',
            4 => 'Packing',
            5 => 'Delivered',
            6 => 'Cancelled',
        ], [
            'prompt' => 'Select Status...',
            'required' => true
        ])
        ->label("Order Status");
    ?> <?= $form->field($model, 'customer_name'); ?>

    <div class="form-group actions">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>