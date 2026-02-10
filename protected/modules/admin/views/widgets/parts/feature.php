<?php
$prefix = $attribute . '[' . $key . '][content][feature][' . $k . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <div class="_2divs">
            <?= $form->field($model, $prefix . "[text]")->textInput(['required' => 'required'])->label("Text") ?>
            <div class="form-group">
                <label class="control-label">Images</label>
                <?php
                $tmp = explode("\\", get_class($model));
                $modelName = end($tmp);
                $selImage = @$model->{$attribute}[$key]['content']['feature'][$k]['image_id'];
                $imageObj = \app\models\Media::find()->where(['id' => $selImage])->one();
                ?>
                <?=
                $this->render('@app/widgets/fileupload', [
                    'name' => 'feature',
                    'hidden' => $modelName . '[' . $attribute . ']' . '[' . $key . ']' . '[content][feature][' . $k . '][image_id]',
                    'hidden_id' => strtolower($modelName) . "-" . $attribute . "-" . $key . "-content-feature-" . $k . "-image_id",
                    'existing' => $imageObj,
                    'drag' => false
                ]);
                ?>
            </div>
        </div>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>