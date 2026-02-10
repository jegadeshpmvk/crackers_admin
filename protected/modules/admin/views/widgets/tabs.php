<?php
$keyprefix = $attribute . '[' . $key . ']';
?>
<div class="flexible-li">
    <div class="flexible-item" data-key="<?= $key ?>">
        <h1 class="flexible-title">FAQS</h1>
        <?= $form->field($model, $keyprefix . '[type]', ['options' => ['tag' => false]])->hiddenInput(['value' => 'tabs'])->label(false) ?>

        <div class="form-group">
            <label class="control-label">Tabs</label>
            <div class="repeater-wrap">
                <ol class="repeater" data-rel="tab">
                    <?php
                    if (isset($model->{$attribute}[$key]['content']['tab']) && count($model->{$attribute}[$key]['content']['tab']) > 0) {
                        foreach ($model->{$attribute}[$key]['content']['tab'] as $k => $link) {
                            echo $this->render('parts/tab', [
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