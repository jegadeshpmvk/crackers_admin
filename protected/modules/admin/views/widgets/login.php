<?php
$keyprefix = $attribute . '[' . $key . ']';
?>
<div class="flexible-li">
    <div class="flexible-item" data-key="<?= $key ?>">
        <h1 class="flexible-title">Login Register Form</h1>
        <?= $form->field($model, $keyprefix . '[type]', ['options' => ['tag' => false]])->hiddenInput(['value' => 'login'])->label(false) ?>
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
    </div>
    <?= $this->render('@app/widgets/flexible-options', ['attribute' => $attribute, 'key' => $key]); ?>
</div>