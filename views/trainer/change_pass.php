<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
//$this->registerCssFile('/css/sort-by-form.css');
?>
<style>
    .main-nav a[href='/trainer/login']{
        color: white;
        background: rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(0, 0, 0, 0.3);
        font-family: "Proxima Light";
    }

    ::-webkit-input-placeholder { /* Chrome */
        color: black !important;
    }
    :-ms-input-placeholder { /* IE 10+ */
        color: black !important;
    }
    ::-moz-placeholder { /* Firefox 19+ */
        color: black !important;
        opacity: 1 !important;
    }
    :-moz-placeholder { /* Firefox 4 - 18 */
        color: black !important;
        opacity: 1;
    }

</style>

<div class="site-login">
    <h1 class="page-title">Change password</h1>
    <div class="enter-container login-form">
        <span class="divider-ico horse-01-ico"></span>

        <?php $form = ActiveForm::begin([
            'id' => 'changepass-form',
            'enableClientValidation' => false,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class='col-lg-12'>{input}</div>\n<div class='help-block'>{error}</div>",

            ],
        ]); ?>

        <?= $form->field($model, 'pass')->textInput(['autofocus' => true, 'placeholder' => 'OLD PASSWORD'])->label(false) ?>

        <?= $form->field($model, 'pass')->passwordInput(['placeholder' => 'NEW PASSWORD'])->label(false) ?>

        <div class="form-group" align="center">
            <?= Html::submitButton('Submit', ['class' => 'login-button btn', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
