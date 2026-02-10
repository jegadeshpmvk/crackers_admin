<?php
$prefix = $attribute . '[' . $key . '][content][how-work][' . $k . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <div class="_2divs">
            <div class="form-group">
                <label class="control-label">Images</label>
                <?php
                $tmp = explode("\\", get_class($model));
                $modelName = end($tmp);
                $selImage = @$model->{$attribute}[$key]['content']['how-work'][$k]['image_id'];
                $imageObj = \app\models\Media::find()->where(['id' => $selImage])->one();
                ?>
                <?=
                $this->render('@app/widgets/fileupload', [
                    'name' => 'feature',
                    'hidden' => $modelName . '[' . $attribute . ']' . '[' . $key . ']' . '[content][how-work][' . $k . '][image_id]',
                    'hidden_id' => strtolower($modelName) . "-" . $attribute . "-" . $key . "-content-how-work-" . $k . "-image_id",
                    'existing' => $imageObj,
                    'drag' => false
                ]);
                ?>
            </div>
            <?= $form->field($model, $prefix . "[video_link]")->textInput(['required' => 'required'])->label("Video Link") ?>
            <?= $form->field($model, $prefix . "[title]")->textInput(['required' => 'required'])->label("Title") ?>
            <?= $form->field($model, $prefix . "[text]")->textInput(['required' => 'required'])->label("Text") ?>
        </div>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>