<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>
<div class="middle-wrap-abs login_page">
    <div class="middle">
        <a href="<?= Url::home() ?>" class="logo_a">
            <img class="logo" src="<?= Yii::getAlias("@icons") ?>/logo.png" />
        </a>
        <div class="login_form">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group f-l">
                <label class="has-checkbox" for="client-login-rememberme">
                    <input type="checkbox" id="client-login-rememberme" name="ClientLogin[rememberMe]" value="1">
                    <span class="square"></span><span>Remember Me</span>
                </label>
            </div>
            <div class="form-group has-submit f-r">
                <?= Html::submitButton('<span>Log In</span>', ['class' => 'button button-primary', 'name' => 'login-button']) ?>
            </div>
            <div class="clear"></div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="lost_back">
            <div class="">
                <a class="lost" href="<?= Url::to(['default/forgot']) ?>">Lost your password?</a>
            </div>
            <div class="">
                <a href="<?= Url::home() ?>" class="back">← Back to Home</a>
            </div>
        </div>
    </div>
</div>