<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\RegisterTrainer */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register | Liberty Academy';

$this->registerCssFile('/build/trainer_forms.css');

?>

<div class="container register-form-container register-personal">

    <h1 class="page-title">Register</h1>
    <h2 class="form-section-title">Step 2/3: Personal info</h2>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'options' => [
            'class' => 'register-form personal-info-fields',
            'enctype' => 'multipart/form-data'
        ],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n<div class='row help-block'>{error}</div>",
            'horizontalCssClasses' => [
                'label' => ''
            ]
        ],
        'encodeErrorSummary' => false
    ]); ?>

    <?= $this->render('form_fields/_personal_info_fields', [
        'model' => $model,
        'form' => $form,
    ]); ?>

    <?= $form->field($model, 'pass')->passwordInput(['maxlength' => true])->label('Choose a password') ?>

    <div class="form-group" align="center">
        <?= Html::a('Back', ['/trainer/register'], ['class' => 'btn btn-wide']) ?>
        <?= Html::submitButton('Next', ['class' => 'btn btn-wide', 'name' => 'submit-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>