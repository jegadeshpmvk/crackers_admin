<?php
$prefix = $attribute . '[' . $key . '][content][slider][' . $k . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <div class="_2divs">
            <div class="form-group">
                <label class="control-label">Images</label>
                <?php
                $tmp = explode("\\", get_class($model));
                $modelName = end($tmp);
                $selImage = @$model->{$attribute}[$key]['content']['slider'][$k]['image_id'];
                $imageObj = \app\models\Media::find()->where(['id' => $selImage])->one();
                ?>
                <?=
                $this->render('@app/widgets/fileupload', [
                    'name' => 'banner',
                    'hidden' => $modelName . '[' . $attribute . ']' . '[' . $key . ']' . '[content][slider][' . $k . '][image_id]',
                    'hidden_id' => strtolower($modelName) . "-" . $attribute . "-" . $key . "-content-slider-" . $k . "-image_id",
                    'existing' => $imageObj,
                    'drag' => false
                ]);
                ?>
            </div>
        </div>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>