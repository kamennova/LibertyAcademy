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

?>

<div class="row">
    <div class="col-sm-6 left-field">
        <?= $form->field($model, 'email', ['errorOptions' => ['class' => 'help-block', 'encode' => false]])->input('email')->label('Email') ?>
    </div>
    <div class="col-sm-6 right-field">
        <?= $form->field($model, 'homecountry_id')->dropDownList(Country::find()->select(['country_name'])->indexBy('id')->column(), ['prompt' => 'select']) ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 left-field">
        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-6 right-field">
        <?= $form->field($model, 'address')->textInput(['options' => ['color' => 'black']]) ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($model, 'teachCountries')
            ->widget(Select2::className(), [
                'data' => Country::find()->select('country_name')->indexBy('id')->column(),
                'options' => [
                    'errorText' => 'This field can not be blank',
                    'placeholder' => 'Countries',
                    'class' => 'form-control',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'width' => '100%'
                ],
            ])->label('Where do you teach?'); ?>

    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'soc_fb')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'soc_inst')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'soc_tw')->textInput(['maxlength' => true]) ?>
    </div>
</div>



