<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Country;
use app\models\TrainerStatus;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';
$this->registerCssFile('/css/register.css');
?>

<style>
    .main-nav a[href='/trainer/register'] {
        color: white;
        background: rgba(0, 0, 0, 0.6);
        border: 1px solid rgba(0, 0, 0, 0.3);
        font-family: "Proxima Light";
    }

    .register-container {
        background: white;
        width: 100%;
        margin: 30px auto;
        padding: 20px 100px;
    }

    .modal {
        display: block
    }

    .fade {
        opacity: 1
    }

    .register-personal, .register-contact {
        width: 960px;
        padding: 20px 50px 30px;
        margin: 60px auto 0;
        box-shadow: 0 3px 10px 0 rgba(0, 0, 0, 0.2) !important;
    }

</style>


<script>
    window.onload($('#rulesModal').modal());
</script>

<div class="register-rules-container">
    <div class="row">
        <div class="col-sm-6 background">
            <span class="logo-small register-logo"></span>
            <h2 class="section-title register-rules-title">Register</h2>
            <h3 class="section-subtitle">Step 1: Rules</h3>

            <hr class="article-hr">

            <p>To join the trainers' community please make sure you agree with liberty philosophy and the rules of
                registration</p>
        </div>
        <div class="col-sm-6 rules-col">


            <?php $form = ActiveForm::begin([]) ?>

            <?= $form->field($model, 'no_bits')->checkbox(['label' => 'I never use bits']) ?>
            <?= $form->field($model, 'no_violence')->checkbox(['label' => 'I never use physical punishment while training horses ']) ?>
            <?= $form->field($model, 'no_sports')->checkbox(['label' => 'I don\'t accept and don\'t take part in traditional horse sports']) ?>


            <div class="form-group" align="center">
                <?= Html::submitButton('confirm', ['class' => 'btn login-button', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>


<div class="register-container register-form register-personal">
    <h2 class="section-title">Register</h2>
    <h2 class="section-subtitle">Step 2: Personal info</h2>
    <div class="row">
        <div class="col-sm-6">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'enableClientValidation' => false,
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "<div class='row'><div class='col-lg-4'>{label}</div>\n<div class=\"col-lg-8\">{input}</div></div>\n<div class='help-block'>{error}</div>"
                ],
                'encodeErrorSummary' => false
            ]); ?>



            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'id_status')->dropDownList(TrainerStatus::find()->select(['name'])->indexBy('id')->column())->label('Working as?') ?>

            <?= $form->field($model, 'org')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'desc', [
                'template' => "<div class='row'><div class='col-lg-12'>{label}</div></div><br>\n<div class='row'><div class=\"col-lg-12\">{input}</div></div>\n<div class='help-block'>{error}</div>"
            ])->textarea(['maxlength' => '90', 'rows' => 2]) ?>

            <?= $form->field($model, 'credo')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'horses')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'authorities')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Ammunition') ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'big_desc', ['template' => '<div class="row"><div class="col-sm-12">{label}</div></div><div class="row"><div class="col-lg-12">{input}{error}{hint}</div></div>'])
                ->widget(CKEditor::className(), [
                    'options' => ['height' => 'auto'],
                    'preset' => 'basic'
                ]) ?>

        </div>

        <div class="form-group" align="center">
            <?= Html::submitButton('Next', ['class' => 'btn login-button', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>


<div class="register-container register-form register-contact">
    <h2 class="section-title">Register</h2>
    <h2 class="section-subtitle">Step 3: Contact info</h2>


    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'enableClientValidation' => false,
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "<div class='row'><div class='col-lg-4'>{label}</div>\n<div class=\"col-lg-8\">{input}</div></div>\n<div class='help-block'>{error}</div>"
        ],
        'encodeErrorSummary' => false
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'email', ['errorOptions' => ['class' => 'help-block', 'encode' => false]])->input('email')->label('Email') ?>

            <?= $form->field($model, 'homecountry_id')->dropDownList(Country::find()->select(['country_name'])->indexBy('id')->column(), ['prompt' => 'select']) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'address')->textInput(['options' => ['color' => 'black']]) ?>

    <?= $form->field($model, 'teachCountries')
        ->widget(Select2::className(), [
            'data' => Country::find()->select('country_name')->indexBy('id')->column(),
            'options' => [
                'placeholder' => 'Countries',
                'class' => 'form-control',
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'width' => '100%'
            ],
        ])->label('Teaching countries'); ?>

    <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'soc_fb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'soc_inst')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'soc_tw')->textInput(['maxlength' => true]) ?>
    <?php ActiveForm::end(); ?>

</div>


