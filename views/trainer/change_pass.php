<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/css/forms.css');
?>

<div class="site-login">
    <h1 class="page-title">Change password</h1>
    <div class="enter-container login-form-container login-form">
        <span class="divider-ico horse-01-ico"></span>

        <?php $form = ActiveForm::begin([
            'id' => 'changepass-form',
            'enableClientValidation' => false,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class='col-lg-12'>{input}</div>\n<div class='help-block'>{error}</div>",

            ],
        ]); ?>

        <?= $form->field($model, 'old_password')->passwordInput(['autofocus' => true, 'placeholder' => 'Old password']) ?>
        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => 'New password']) ?>
        <?= $form->field($model, 'repeat')->passwordInput(['placeholder' => 'Repeat']) ?>

        <div class="form-group" align="center">
            <?= Html::submitButton('Submit', ['class' => 'login-button btn', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>