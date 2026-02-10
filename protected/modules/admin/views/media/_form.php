<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$form = ActiveForm::begin();
?>

<div class="model-form widgets button_margin">
    <h1 class="widgets_title">Media</h1>
    <div class="widgets_content common_form event_form">
        <div class="form-group amenities_repeater">
            <div class="form-group hidden_image_upload">
                <label class="control-label">Images</label>
                <?=
                $this->render('@app/widgets/fileupload', [
                    'name' => '',
                    'hidden' => false,
                    'hidden_id' => false,
                    'existing' => [],
                    'drag' => false
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<div class="options">
    <?= Html::a('Save', ['media/index'], ['class' => 'fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>