<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
//$this->registerCssFile('/css/sort-by-form.css');
$this->registerCssFile('/css/forms.css');

?>

<!--<div class="site-login">-->
    <div class="login-form-container enter-container login-form">

        <h1 class="page-title">Log in</h1>
        
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'enableClientValidation' => false,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "<div class='col-lg-12'>{input}</div>\n<div class='help-block'>{error}</div>"
            ],
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>

        <div class="form-group" align="center">
            <?= Html::submitButton('Log in', ['class' => 'btn login-btn', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<!--</div>-->