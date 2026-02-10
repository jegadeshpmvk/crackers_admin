<?php
$prefix = $attribute . '[' . $key . ']';
?>
<li>
    <div class="repeater-item" data-key="<?= $key ?>">
        <?= $form->field($model, $prefix . "[name]")->textInput(['required' => 'required'])->label('Bank Name'); ?>
        <?= $form->field($model, $prefix . "[holder_name]")->textInput(['required' => 'required'])->label('Account Holder Name'); ?>
        <?= $form->field($model, $prefix . "[account_number]")->textInput(['required' => 'required'])->label('Account Number'); ?>
        <?= $form->field($model, $prefix . "[ifsc_code]")->textInput(['required' => 'required'])->label('IFSC Code'); ?>
        <?= $form->field($model, $prefix . "[branch_name]")->textInput(['required' => 'required'])->label('Branch Name'); ?>
    </div>
    <?= $this->render('@app/widgets/repeater-options'); ?>
</li>