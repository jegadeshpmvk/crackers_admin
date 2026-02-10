<?php
$prefix = $attribute . '[' . $key . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <div class="_2divs">          
            <div class="form-group form-group_amenities_icon">
                <label class="control-label" >Image</label>
                <?php
                $tmp = explode("\\", get_class($model));
                $modelName = end($tmp);
                $selImage = @$model->{$attribute}[$key]['image_id'];
                $imageObj = \app\models\Media::find()->where(['id' => $selImage])->one();
                ?>
                <?=
                $this->render('@app/widgets/fileupload', [
                    'name' => 'images',
                    'hidden' => $modelName . '[' . $attribute . ']' . '[' . $key . '][image_id]',
                    'hidden_id' => strtolower($modelName) . "-" . $attribute . "-" . $key . "-image_id",
                    'existing' => $imageObj,
                    'drag' => false
                ]);
                ?>
            </div>
        </div>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>