<?php
$keyprefix = $attribute . '[' . $key . ']';
?>
<div class="flexible-li">
    <div class="flexible-item" data-key="<?= $key ?>">
        <h1 class="flexible-title">Three Boxes</h1>
        <?= $form->field($model, $keyprefix . '[type]', ['options' => ['tag' => false]])->hiddenInput(['value' => 'three-box'])->label(false) ?>
        <div class="form-group">
            <?php
            $tmp = explode("\\", get_class($model));
            $modelName = end($tmp);

            $selImage = @$model->{$attribute}[$key]['content']['image_id'];
            $imageObj = \app\models\Media::find()->where(['id' => $selImage])->one();
            ?>
            <?=
            $this->render('@app/widgets/fileupload', [
                'name' => 'banner',
                'hidden' => $modelName . '[' . $attribute . ']' . '[' . $key . ']' . '[content][image_id]',
                'hidden_id' => strtolower($modelName) . "-" . $attribute . "-" . $key . "-content-image_id",
                'existing' => $imageObj,
                'browse' => true
            ]);
            ?>
        </div>
        <div class="form-group">
            <label class="control-label">Grid</label>
            <div class="repeater-wrap">
                <ol class="repeater" data-rel="three-box">
                    <?php
                    if (isset($model->{$attribute}[$key]['content']['three-box']) && count($model->{$attribute}[$key]['content']['three-box']) > 0) {
                        foreach ($model->{$attribute}[$key]['content']['three-box'] as $k => $link) {
                            echo $this->render('parts/three-box', [
                                'model' => $model,
                                'form' => $form,
                                'key' => $key,
                                'k' => $k,
                                'attribute' => $attribute
                            ]);
                        }
                    }
                    ?>
                </ol>
                <a class="button repeat-add"><span>Add Item</span></a>
            </div>
        </div>
    </div>
    <?= $this->render('@app/widgets/flexible-options', ['attribute' => $attribute, 'key' => $key]); ?>
</div>