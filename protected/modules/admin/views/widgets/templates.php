<div class="flexible-templates">
    <?php
    $flexibleTypes = Yii::$app->function->flexibleContentTypes();
    foreach ($flexibleTypes as $f => $flexType) {
        if (in_array($attribute, $flexType["type"])) {
    ?>
            <div data-for="<?= $f ?>">
                <?=
                $this->render($f, [
                    'model' => $model,
                    'form' => $form,
                    'key' => $key,
                    'attribute' => $attribute
                ]);
                ?>
            </div>
    <?php
        }
    }
    ?>
</div>

<div class="templates">
    <?php if ($attribute == "content_widgets") { ?>
        <div data-for="slider">
            <?=
            $this->render('parts/slider', [
                'model' => $model,
                'form' => $form,
                'key' => 0,
                'k' => 0,
                'attribute' => $attribute
            ]);
            ?>
        </div>
        <div data-for="three-box">
            <?=
            $this->render('parts/three-box', [
                'model' => $model,
                'form' => $form,
                'key' => 0,
                'k' => 0,
                'attribute' => $attribute
            ]);
            ?>
        </div>
        <div data-for="feature">
            <?=
            $this->render('parts/feature', [
                'model' => $model,
                'form' => $form,
                'key' => 0,
                'k' => 0,
                'attribute' => $attribute
            ]);
            ?>
        </div>
        <div data-for="how-work">
            <?=
            $this->render('parts/how-work', [
                'model' => $model,
                'form' => $form,
                'key' => 0,
                'k' => 0,
                'attribute' => $attribute
            ]);
            ?>
        </div>
        <div data-for="faq">
            <?=
            $this->render('parts/faq', [
                'model' => $model,
                'form' => $form,
                'key' => 0,
                'k' => 0,
                'attribute' => $attribute
            ]);
            ?>
        </div>
        <div data-for="testimonial">
            <?=
            $this->render('parts/testimonial', [
                'model' => $model,
                'form' => $form,
                'key' => 0,
                'k' => 0,
                'attribute' => $attribute
            ]);
            ?>
        </div>
        <div data-for="tab">
            <?=
            $this->render('parts/tab', [
                'model' => $model,
                'form' => $form,
                'key' => 0,
                'k' => 0,
                'attribute' => $attribute
            ]);
            ?>
        </div>
    <?php } ?>
</div>