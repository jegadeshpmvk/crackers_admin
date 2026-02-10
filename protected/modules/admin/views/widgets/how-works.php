<?php
$keyprefix = $attribute . '[' . $key . ']';
?>
<div class="flexible-li">
    <div class="flexible-item" data-key="<?= $key ?>">
        <h1 class="flexible-title">How Works</h1>
        <?= $form->field($model, $keyprefix . '[type]', ['options' => ['tag' => false]])->hiddenInput(['value' => 'how-works'])->label(false) ?>
        <?= $form->field($model, $keyprefix . '[content][title]')->textInput(['class' => ''])->label("Title"); ?>
        <div class="form-group">
            <label class="control-label">Grid</label>
            <div class="repeater-wrap">
                <ol class="repeater" data-rel="how-work">
                    <?php
                    if (isset($model->{$attribute}[$key]['content']['how-work']) && count($model->{$attribute}[$key]['content']['how-work']) > 0) {
                        foreach ($model->{$attribute}[$key]['content']['how-work'] as $k => $link) {
                            echo $this->render('parts/how-work', [
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