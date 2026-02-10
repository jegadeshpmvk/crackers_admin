<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
?>

<div class="model-form widgets button_margin">
    <h1 class="widgets_title">Category details</h1>
    <div class="widgets_content common_form event_form">
        <div class="event_coloum_1">
            <div class="_2divs">
                <?= $form->field($model, 'name')
                    ->label('To Agent')
                    ->textInput(['required' => true, 'maxlength' => 255]) ?>
                <?= $form->field($model, 'code')->label('Promocode')->textInput(['required' => true, 'maxlength' => 255]) ?>
            </div>
            <div class="_2divs">
                <?= $form->field($model, 'discount')
                    ->label('Discount (%)')
                    ->textInput(['required' => true, 'maxlength' => 255]) ?>
            </div>
        </div>
    </div>
</div>

<div class="options">
    <?= Html::submitButton('Save', ['class' => 'fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>