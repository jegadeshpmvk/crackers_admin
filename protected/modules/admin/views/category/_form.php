<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$form = ActiveForm::begin();
?>

<div class="model-form widgets button_margin">
    <h1 class="widgets_title">Category details</h1>
    <div class="widgets_content common_form event_form">
        <div class="event_coloum_1">
            <div class="_2divs">
                <?= $form->field($model, 'name')->textInput(['required' => 'required', 'maxlength' => 255]) ?>
                <?= $form->field($model, 'discount')->textInput(['maxlength' => 255]) ?>
                <?= $form->field($model, 'alignment')->textInput(['required' => 'required', 'maxlength' => 5]); ?>
            </div>
        </div>
    </div>
</div>

<div class="options">
    <?= Html::submitButton('Save', ['class' => 'fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>