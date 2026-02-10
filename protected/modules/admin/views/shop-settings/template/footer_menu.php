<?php
$prefix = $attribute . '[' . $key . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <?= $form->field($model, $prefix . "[name]")->textInput(['required' => 'required'])->label('Name') ?>
        <?= $form->field($model, $prefix . "[link]")->textInput(['required' => 'required'])->label('Link'); ?>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>