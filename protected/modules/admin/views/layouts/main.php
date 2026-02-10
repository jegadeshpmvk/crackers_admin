<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Spaceless;
use app\modules\admin\AdminAsset;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?= Url::to('@icons') ?>/favicon.ico" type="image/ico">
        <?= Html::csrfMetaTags() ?>
        <title><?= Yii::$app->name ?></title>
        <?php $this->head(); ?>
        <script type="text/javascript">var cookie_prefix = "<?= Yii::$app->name ?>";</script>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div id="loading-screen" class="loading">
            <div class="v-aln-wr">
                <div class="v-aln">
                    <div id="noscript" class="aln-c">Please enable JavaScript in your browser to access this website.</div>
                    <div id="load-spinner" class="load-text">
                        <div class="left"></div>
                        LOADING
                    </div>
                </div>
            </div>
        </div>  
        <script type="text/javascript">
            /*<![CDATA[*/
            var elem = document.getElementById("loading-screen");
            elem.parentNode.removeChild(elem);
            var _app_prefix = "<?= Yii::getAlias('@prefix') ?>";
            /*]]>*/
        </script>
        <?php if (!Yii::$app->controller->onlyContent) { ?>
            <div class="header">
                <?php
                foreach (Yii::$app->session->getAllFlashes() as $key => $message)
                    echo '<div class="alert alert-' . $key . '"><span><i class="fa ' . ($key == "success" ? "fa-check" : "fa-times") . '"></i>' . $message . '</span></div>';
                ?>
                <div class="logo">
                    <a href="<?= Url::home() ?>" class="ab-item" target="_blank"><span><?php echo Yii::$app->name; ?></span></a>
                </div>
            </div>
            <div class="panel left">
                <div class="panel_left_div"></div>
                <?php if (!Yii::$app->admin->isGuest) echo $this->render('menu'); ?>
            </div>
            <div class="panel right">
                <div class="content">
                    <?php
                }
                Spaceless::begin();
                echo $content;
                Spaceless::end();
                ?>
                <?php if (!Yii::$app->controller->onlyContent) { ?>
                </div>
            </div>
            <!-- Search Bar (Used to search gridview) -->
            <div class="bar search-bar">
                <?= Html::a('<span>Back</span>', NULL, ['class' => 'btn fa fa-arrow-left']) ?>       
                <div class="bar-options">
                    <?= Html::a('<span>Go</span>', NULL, ['class' => 'btn fa fa-search']) ?>
                    <?= Html::a('<span>Reset</span>', NULL, ['class' => 'btn fa fa-refresh']) ?>
                </div>
            </div>
            <!-- Sorting Bar (Used to sort the rows in gridview) -->
            <div class="bar sort-bar">
                <?= Html::a('<span>Back</span>', NULL, ['class' => 'btn fa fa-arrow-left']) ?>
                <div class="bar-options">
                    <?= Html::a('<span>Save</span>', NULL, ['class' => 'btn fa fa-save']) ?>
                </div>
            </div>
            <!-- Image Library Bar (Allow users to select images from a library) -->
            <div class="bar image-library-bar">
                <?= Html::a('<span>Back</span>', NULL, ['class' => 'btn fa fa-arrow-left']) ?>
                <h1><span>Media Library</span></h1>
                <div class="bar-options">
                    <?= Html::a('<span>Select</span>', NULL, ['class' => 'btn fa fa-check']) ?>
                </div>
            </div>
            <div class="image-library">
                <div class="images-container"></div>
            </div>
            <div class="linkbox code">
                <div class="middle-wrap-table">
                    <div class="middle">
                        <div class="wrap">
                            <div class="form-group">
                                <label class="control-label">Highlighted Text</label>
                                <input type="text" class="seltext">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Link To</label>
                                <?php echo Html::dropDownList("href", "", Yii::$app->page->paths(false, true), ['prompt' => 'Select...', 'class' => 'href']) ?>
                            </div>
                            <div class="buttons">
                                <?= Html::submitButton('Save', ['class' => 'fa fa-save']) ?>
                                <?= Html::a('Discard', "#", ['class' => 'fa fa-remove', 'onClick' => 'window.parent.blogIframe.close();']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bar flexible-library-bar">
                <?= Html::a('Back', NULL, ['class' => 'btn fa fa-arrow-left close-flexible-layout']) ?>
                <h1><span class="flexible-library-title">Content Widget Library</span></h1>
            </div>
            <div class="flexible-library">
                <div class="flexible-list-outer">
                    <div class="flexible-list">
                        <?php
                        $flexibleTypes = Yii::$app->function->flexibleContentTypes();
                        foreach ($flexibleTypes as $f => $flexType) {
                            ?>
                            <a class="flexible-list-item <?= implode(" ", $flexType["type"]) ?>" data-type="<?= $f ?>">
                                <div class="flexible-list-wrap">
                                    <div class="flexible-image">
                                        <div class="flexible-image-sizer"></div>
                                        <div class="flexible-image-bsz" style="background-image: url('<?= $flexType['image'] ?>')"></div>
                                    </div>
                                    <h1 class="flexible-list-title"><?= $flexType['title'] ?></h1>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
