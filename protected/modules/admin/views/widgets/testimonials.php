<?php
$keyprefix = $attribute . '[' . $key . ']';
?>
<div class="flexible-li">
    <div class="flexible-item" data-key="<?= $key ?>">
        <h1 class="flexible-title">Features</h1>
        <?= $form->field($model, $keyprefix . '[type]', ['options' => ['tag' => false]])->hiddenInput(['value' => 'testimonials'])->label(false) ?>
        <?= $form->field($model, $keyprefix . '[content][title]')->textInput(['required' => 'required'])->label("Title"); ?>
        <?= $form->field($model, $keyprefix . '[content][sub_title]')->textInput(['required' => 'required'])->label("Sub Title"); ?>
        <div class="form-group">
            <label class="control-label">Grid</label>
            <div class="repeater-wrap">
                <ol class="repeater" data-rel="testimonial">
                    <?php
                    if (isset($model->{$attribute}[$key]['content']['testimonial']) && count($model->{$attribute}[$key]['content']['testimonial']) > 0) {
                        foreach ($model->{$attribute}[$key]['content']['testimonial'] as $k => $link) {
                            echo $this->render('parts/testimonial', [
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