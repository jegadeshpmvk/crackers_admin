<?php
$prefix = $attribute . '[' . $key . '][content][tab][' . $k . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <div class="_2divs">
            <?= $form->field($model, $prefix . "[title]")->textInput(['required' => 'required'])->label("Title") ?>
            <?= $form->field($model, $prefix . '[text]')->textArea(['class' => 'contentEditor repeater-widget-editor', 'required' => 'required'])->label("Text") ?>
        </div>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>