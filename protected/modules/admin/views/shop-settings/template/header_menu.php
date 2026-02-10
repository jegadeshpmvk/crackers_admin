<?php
$prefix = $attribute . '[' . $key . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <div class="form-group radio_button">
            <label class="control-label">Type</label>
            <?=
            $this->render('@app/widgets/radio-list', [
                'form' => $form,
                'model' => $model,
                'field' => $prefix . '[link_type]',
                'list' => (["link" => "Link", "button" => "Button"])
            ]);
            ?>
        </div>
        <div class="_2_col_form form-group">
            <?= $form->field($model, $prefix . "[name]")->textInput(['required' => 'required'])->label('Name'); ?>
            <?= $form->field($model, $prefix . "[link]")->textInput(['required' => 'required'])->label('Link'); ?>
        </div>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>