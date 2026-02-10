<?php
$keyprefix = $attribute . '[' . $key . ']';
?>
<div class="flexible-li">
    <div class="flexible-item" data-key="<?= $key ?>">
        <h1 class="flexible-title">FAQS</h1>
        <?= $form->field($model, $keyprefix . '[type]', ['options' => ['tag' => false]])->hiddenInput(['value' => 'faqs'])->label(false) ?>
        <?= $form->field($model, $keyprefix . '[content][title]')->textInput(['class' => ''])->label("Title"); ?>
        <div class="form-group">
            <label class="control-label">Grid</label>
            <div class="repeater-wrap">
                <ol class="repeater" data-rel="faq">
                    <?php
                    if (isset($model->{$attribute}[$key]['content']['faq']) && count($model->{$attribute}[$key]['content']['faq']) > 0) {
                        foreach ($model->{$attribute}[$key]['content']['faq'] as $k => $link) {
                            echo $this->render('parts/faq', [
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