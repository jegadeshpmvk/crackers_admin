<?php
$prefix = $attribute . '[' . $key . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <?= $form->field($model, $prefix . "[name]")->dropDownList($model->pay, ['required' => 'required'])->label("Select Pay"); ?>
        <?= $form->field($model, $prefix . "[number]")->textInput(['required' => 'required'])->label('Number'); ?>
        <div class="form-group form-group_amenities_icon">
            <label class="control-label">QR Code</label>
            <?php
            $tmp = explode("\\", get_class($model));
            $modelName = end($tmp);
            $selImage = @$model->{$attribute}[$key]['qr_code_id'];
            $imageObj = \app\models\Media::find()->where(['id' => $selImage])->one();
            ?>
            <?=
            $this->render('@app/widgets/fileupload', [
                'name' => 'qr_code',
                'hidden' => $modelName . '[' . $attribute . ']' . '[' . $key . '][qr_code_id]',
                'hidden_id' => strtolower($modelName) . "-" . $attribute . "-" . $key . "-qr_code_id",
                'existing' => $imageObj,
                'drag' => false
            ]);
            ?>
        </div>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>