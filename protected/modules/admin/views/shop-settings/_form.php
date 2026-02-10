<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<h1 class="p-tl"><?php echo $model->isNewRecord ? "Create" : "Update"; ?> Shop Settings</h1>
<div class="model-form widgets">
    <h1 class="widgets_title">Shop Settings</h1>
    <div class="widgets_content">
        <div class="_4divs">
            <?= $form->field($model, 'shop_name')->textInput(['required' => true]) ?>
            <?= $form->field($model, 'shop_code')->textInput(['required' => true]) ?>
            <?= $form->field($model, 'min_order')->label('Minimum Order Value (Rs)')->textInput(['required' => true]); ?>
            <?= $form->field($model, 'bill_discount')->label('Billing Discount (%)')->textInput(['required' => true]); ?>
        </div>
        <div class="_4divs">
            <?= $form->field($model, 'whatsapp_number') ?>
            <?= $form->field($model, 'mobile_number')->textInput(['required' => true]) ?>
            <?= $form->field($model, 'alternate_mobile_mumber') ?>
            <?= $form->field($model, 'email_id')->label('Email ID')->textInput(['required' => true]); ?>
        </div>
        <div class="_4divs">
            <?= $form->field($model, 'google_map_loaction')->label('GoogleMap Location URL'); ?>
            <?= $form->field($model, 'google_map_embeed')->label('GoogleMap Embed URL'); ?>
            <?= $form->field($model, 'address')->label('Address'); ?>
            <?= $form->field($model, 'gst_no')->label('GST No')->textInput(['required' => true]); ?>
        </div>
    </div>
</div>
<div class="model-form widgets">
    <h1 class="widgets_title">Bank Details</h1>

    <div class="widgets_content">
        <div class="form-group">
            <div class="repeater-wrap">
                <ol class="repeater _2cols" data-rel="bank_details">
                    <?php
                    if (isset($model->bank_details) && count($model->bank_details) > 0) {
                        foreach ($model->bank_details as $k => $dl) {
                            echo $this->render('@app/modules/admin/views/shop-settings/template/bank_details', [
                                'model' => $model,
                                'form' => $form,
                                'key' => $k,
                                'attribute' => "bank_details"
                            ]);
                        }
                    }
                    ?>
                </ol>
                <a class="button repeat-add"><span>Add Item</span></a>
            </div>
        </div>
    </div>
</div>
<div class="model-form widgets">
    <h1 class="widgets_title">Social Media</h1>

    <div class="widgets_content">
        <div class="form-group">
            <div class="repeater-wrap">
                <ol class="repeater _2cols" data-rel="social_media">
                    <?php
                    if (isset($model->social_media) && count($model->social_media) > 0) {
                        foreach ($model->social_media as $k => $dl) {
                            echo $this->render('@app/modules/admin/views/shop-settings/template/social_media', [
                                'model' => $model,
                                'form' => $form,
                                'key' => $k,
                                'attribute' => "social_media"
                            ]);
                        }
                    }
                    ?>
                </ol>
                <a class="button repeat-add"><span>Add Item</span></a>
            </div>
        </div>
    </div>
</div>
<div class="model-form widgets">
    <h1 class="widgets_title">Header Information</h1>
    <div class="widgets_content">
        <div class="form-group">
            <label class="control-label">Logo</label>
            <?=
            $this->render('@app/widgets/fileupload', [
                'name' => 'logo',
                'hidden' => 'ShopSettings[logo_id]',
                'hidden_id' => 'shop-settings-logo_id',
                'existing' => $model->logo,
                'browse' => true
            ]);
            ?>
        </div>
        <div class="form-group">
            <label class="control-label">Menu</label>
            <div class="repeater-wrap">
                <ol class="repeater _2cols" data-rel="header_menu">
                    <?php
                    if (isset($model->header_menu) && count($model->header_menu) > 0) {
                        foreach ($model->header_menu as $k => $dl) {
                            echo $this->render('@app/modules/admin/views/shop-settings/template/header_menu', [
                                'model' => $model,
                                'form' => $form,
                                'key' => $k,
                                'attribute' => "header_menu"
                            ]);
                        }
                    }
                    ?>
                </ol>
                <a class="button repeat-add"><span>Add Item</span></a>
            </div>
        </div>
        <div class="form-group amenities_repeater">
            <div class="form-group hidden_image_upload">
                <label class="control-label">Banner Image</label>
                <?=
                $this->render('@app/widgets/fileupload', [
                    'name' => 'banner',
                    'hidden' => 'ShopSettings[banner_ids][]',
                    'hidden_id' => 'shop-settings-banner_ids',
                    'existing' => $model->bannerImages,
                    'drag' => false
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<div class="model-form widgets">
    <h1 class="widgets_title">Footer Information</h1>
    <div class="widgets_content">
        <?= $form->field($model, 'text') ?>
        <?= $form->field($model, 'email') ?>
        <div class="form-group">
            <label class="control-label">Menu</label>
            <div class="repeater-wrap">
                <ol class="repeater _2cols" data-rel="footer_menu">
                    <?php
                    if (isset($model->footer_menu) && count($model->footer_menu) > 0) {
                        foreach ($model->footer_menu as $k => $dl) {
                            echo $this->render('@app/modules/admin/views/shop-settings/template/footer_menu', [
                                'model' => $model,
                                'form' => $form,
                                'key' => $k,
                                'attribute' => "footer_menu"
                            ]);
                        }
                    }
                    ?>
                </ol>
                <a class="button repeat-add"><span>Add Item</span></a>
            </div>
        </div>
        <?= $form->field($model, 'copyrights') ?>
    </div>
</div>
<div class="options">
    <?= Html::submitButton('Save', ['class' => 'fa fa-save']) ?>
</div>

<?php ActiveForm::end(); ?>
<?=
$this->render('@app/modules/admin/views/widgets/allPageArr', []);
?>
<div class="nifty_data"></div>
<div class="templates">
    <div data-for="footer_menu">
        <?=
        $this->render('@app/modules/admin/views/shop-settings/template/footer_menu', [
            'model' => $model,
            'form' => $form,
            'key' => is_array($model->footer_menu) ? count($model->footer_menu) + 1 : 1,
            'attribute' => "footer_menu"
        ]);
        ?>
    </div>
    <div data-for="header_menu">
        <?=
        $this->render('@app/modules/admin/views/shop-settings/template/header_menu', [
            'model' => $model,
            'form' => $form,
            'key' => is_array($model->header_menu) ? count($model->header_menu) + 1 : 1,
            'attribute' => "header_menu"
        ]);
        ?>
    </div>
    <div data-for="social_media">
        <?=
        $this->render('@app/modules/admin/views/shop-settings/template/social_media', [
            'model' => $model,
            'form' => $form,
            'key' => $model->social_media ? count($model->social_media) + 1 : 1,
            'attribute' => "social_media"
        ]);
        ?>
    </div>
    <div data-for="bank_details">
        <?=
        $this->render('@app/modules/admin/views/shop-settings/template/bank_details', [
            'model' => $model,
            'form' => $form,
            'key' => $model->bank_details ? count($model->bank_details) + 1 : 1,
            'attribute' => "bank_details"
        ]);
        ?>
    </div>

</div>