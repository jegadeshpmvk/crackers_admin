<?php
$keyprefix = $attribute . '[' . $key . ']';
?>
<div class="flexible-li">
    <div class="flexible-item" data-key="<?= $key ?>">
        <h1 class="flexible-title">Banner</h1>
        <?= $form->field($model, $keyprefix . '[type]', ['options' => ['tag' => false]])->hiddenInput(['value' => 'banner'])->label(false) ?>
        <?= $form->field($model, $keyprefix . '[content][title]')->textInput(['class' => ''])->label("Title"); ?>
        <?= $form->field($model, $keyprefix . '[content][sub_title]')->textInput(['class' => ''])->label("Sub Title"); ?>
        <?= $form->field($model, $keyprefix . '[content][text]')->textInput(['class' => ''])->label("Text"); ?>
        <?= $form->field($model, $keyprefix . '[content][btn_text]')->textInput(['class' => ''])->label("Button Text"); ?>
        <?= $form->field($model, $keyprefix . '[content][btn_link]')->textInput(['class' => ''])->label("Button Link"); ?>
        <div class="form-group">
            <label class="control-label">Slider</label>
            <div class="repeater-wrap">
                <ol class="repeater" data-rel="slider">
                    <?php
                    if (isset($model->{$attribute}[$key]['content']['slider']) && count($model->{$attribute}[$key]['content']['slider']) > 0) {
                        foreach ($model->{$attribute}[$key]['content']['slider'] as $k => $link) {
                            echo $this->render('parts/slider', [
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