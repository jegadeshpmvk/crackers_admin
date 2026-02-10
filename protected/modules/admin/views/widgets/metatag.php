<div class="model-form widgets seo-section">
    <h1 class="widgets_title">Meta Tags for SEO</h1>
    <div class="widgets_content">
        <?= $form->field($model, $attribute . "[title]")->textInput(['required' => 'required'])->label('Title') ?>
        <?= $form->field($model, $attribute . "[description]")->label('Description') ?>
        <?= $form->field($model, $attribute . "[keywords]")->label('Keywords') ?>
    </div>
</div>