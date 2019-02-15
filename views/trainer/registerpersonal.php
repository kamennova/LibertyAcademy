<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';
$this->registerCssFile('/css/register.css');
$this->registerCssFile('/css/forms.css');

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
            'template' => "<div class='row'><div class='col-lg-12'>{label}\n{input}</div></div>\n<div class='row help-block'>{error}</div>",
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

    <div class="row">

        <div class="col-sm-12">
            <?= $form->field($model, 'pass')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group" align="center">
        <?= Html::a('Back', ['/trainer/register'], ['class' => 'btn btn-wide']) ?>

        <?= Html::submitButton('Next', ['class' => 'btn btn-wide', 'name' => 'submit-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>




