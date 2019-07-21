<?php

use app\models\Country;
use kartik\select2\Select2;

?>

<div class="row">
    <div class="col-sm-6 left-field">
        <?= $form->field($model, 'email', ['errorOptions' => [ 'encode' => false]])
            ->input('email')->label('Email') ?>
    </div>
    <div class="col-sm-6 right-field">
        <?= $form->field($model, 'homecountry_id')->dropDownList(Country::find()->select(['country_name'])
            ->indexBy('id')->column(), ['prompt' => 'select']) ?>
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
<div class="column">
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
                'showToggleAll' => false,
            ])->label('Where do you teach?'); ?>

    </div>

    <?= $form->field($model, 'site')->textInput(['maxlength' => true, 'class' => 'form-control full-width-field']) ?>

    <?= $form->field($model, 'soc_fb')->textInput(['maxlength' => true, 'class' => 'form-control full-width-field']) ?>

    <?= $form->field($model, 'soc_inst')->textInput(['maxlength' => true, 'class' => 'form-control full-width-field']) ?>

    <?= $form->field($model, 'soc_tw')->textInput(['maxlength' => true, 'class' => 'form-control full-width-field']) ?>
</div>