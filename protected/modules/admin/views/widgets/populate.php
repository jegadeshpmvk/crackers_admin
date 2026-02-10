<?php
if (!isset($attribute))
    $attribute = 'content_widgets';
?>
<div class="flexible-content-wrap">
    <div class="flexible-content">
        <?php
        foreach ($model->{$attribute} as $key => $m) {
            if (@$m["type"] != "") {
                echo $this->render(@$m["type"], [
                    'form' => $form,
                    'model' => $model,
                    'key' => $key,
                    'attribute' => $attribute
                ]);
            }
        }
        ?>
    </div>
    <div class="flexible-add-wrap">
        <a class="button flexible-add flexible-add-new" data-type="<?= $attribute ?>"><span>Add Row</span></a>
    </div>
</div>