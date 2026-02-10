<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Category;

$form = ActiveForm::begin();
?>

<div class="model-form widgets button_margin">
    <h1 class="widgets_title">Product details</h1>
    <div class="widgets_content common_form event_form">
        <div class="event_coloum_1">
            <div class="form-group amenities_repeater">
                <div class="form-group hidden_image_upload">
                    <label class="control-label">Product Image</label>
                    <?=
                    $this->render('@app/widgets/fileupload', [
                        'name' => 'product',
                        'hidden' => 'Product[image_ids][]',
                        'hidden_id' => 'product-image_ids',
                        'existing' => $model->images,
                        'drag' => false
                    ]);
                    ?>
                </div>
            </div>
            <div class="_2divs">
                <?= $form->field($model, 'category_id', ['options' => ['class' => 'form-group form_select']])->dropDownList(ArrayHelper::map(Category::find()->active()->all(), 'id', 'name'), ['prompt' => 'Select...', 'required' => 'required'])->label("Category"); ?>
                <?= $form->field($model, 'name')->textInput(['required' => 'required', 'maxlength' => 255]); ?>
            </div>
            <div class="_2divs">
                <?= $form->field($model, 'tamil_name')->textInput(['required' => 'required', 'maxlength' => 255]); ?>
                <?= $form->field($model, 'mrp')->textInput(['type' => 'number', 'required' => 'required', 'maxlength' => 255]); ?>

            </div>
            <div class="_2divs">
                <?= $form->field($model, 'price')->textInput(['type' => 'number', 'required' => 'required', 'maxlength' => 255]); ?>
                <?= $form->field($model, 'type')->textInput(['required' => 'required', 'maxlength' => 255]); ?>
            </div>
            <div class="_2divs">
                <?= $form->field($model, 'video_url')->textInput(); ?>
                <?= $form->field($model, 'alignment')->textInput(['required' => 'required', 'maxlength' => 5]); ?>
                <?= $form->field($model, 'code')->textInput(['required' => 'required']); ?>
            </div>
        </div>
    </div>
</div>

<div class="options">
    <?= Html::submitButton('Save', ['class' => 'fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>


<div class="templates">
    <div data-for="images">
        <?=
        $this->render('@app/modules/admin/views/product/template/images', [
            'model' => $model,
            'form' => $form,
            'key' => is_array($model->images) ? count($model->images) + 1 : 0,
            'attribute' => "images"
        ]);
        ?>
    </div>
</div>