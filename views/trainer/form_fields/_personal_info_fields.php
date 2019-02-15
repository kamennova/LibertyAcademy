<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use app\models\Ammunition;
use app\models\Language;
use app\models\Service;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;

?>

<div class="row">
    <div class="col-sm-12 image-upload">
        <div class="thumbnail"></div>
        <?= $form->field($model, 'imageFile')->fileInput([
            'inputTemplate' => "<div class='row'><div class='col-lg-12'>{beginLabel}{labelTitle}\n<div class='col-sm-12'>{input}</div>{endLabel}</div></div>\n<div class='help-block'>{error}</div>",
            'class' => 'input-hidden']) ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-4 left-field">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4 right-field">
        <?= $form->field($model, 'org')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 left-field services-input">
        <?= $form->field($model, 'services')
            ->widget(Select2::className(), [
                'data' => Service::find()->select('service_name')->indexBy('id')->column(),
                'options' => [
                    'class' => 'form-control',
                    'multiple' => true,
                    'changeOnReset' => false,
                ],
                'pluginOptions' => [
                    'changeOnReset' => false,
                    'allowClear' => true,
                ],
                'changeOnReset' => false,
            ])->label("who are you?"); ?>
    </div>
    <div class="col-sm-6 right-field">
<!-- < ?php
        // Templating example of formatting each list element
        $url = \Yii::$app->urlManager->baseUrl . '/img/flags/';

        $format = <<< SCRIPT
        function format(language) {
        if (!language.lang_code) return language.lang_name; // optgroup
        src = '$url' +  language.lang_code + '.svg'
        return '<img class="flag" src="' + src + '"/>' + language.lang_name;
        }
SCRIPT;

        $escape = new JsExpression("function(m) { return m; }");

        $this->registerJs($format, View::POS_HEAD);

        echo '<label class="control-label">Provinces</label>';
        echo Select2::widget([
            'name' => 'state_12',
            'data' => Language::find()->select('lang_name')->indexBy('id')->column(),
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'templateResult' =>
                    new JsExpression('format')
                ,
                'templateSelection' => new JsExpression('format'),
                'escapeMarkup' => $escape,
                'allowClear' => true
            ],
        ]);

        echo $form->field($model, 'languages')
            ->widget(Select2::className(), [
//            'name' => 'state_12',
            'data' => Language::find()->select('lang_name')->indexBy('id')->column(),
            'options' => [
                    'format' => $format,
                'class' => 'form-control',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'templateResult' => new JsExpression('format'),
                'templateSelection' => new JsExpression('format'),
                'escapeMarkup' => $escape,
                'allowClear' => true
            ],
        ]); ?> -->

        <?= $form->field($model, 'languages')
            ->widget(Select2::className(), [
                'data' => Language::find()->select('lang_name')->indexBy('id')->column(),
                'options' => [
                    'class' => 'form-control',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('Languages you speak'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 description-column">

        <?= $form->field($model, 'desc', [
            'template' => "<div class='row'><div class='col-sm-12'>{label}</div></div>\n<div class='row'><div class=\"col-lg-12\">{input}</div></div>\n<div class='help-block'>{error}</div>"
        ])
//                ->widget(CKEditor::className(), [
//                    'options' => [
//                            'rows' => 2,
//                    ]])

            ->textarea(['maxlength' => '90', 'rows' => 2])->label('Describe your method shortly (100 symbols)') ?>

        <?= $form->field($model, 'big_desc',
            ['template' =>
                '<div class="row"><div class="col-sm-12">{label}</div></div><div class="row"><div class="col-lg-12">{input}{error}{hint}</div></div>'])
            ->widget(CKEditor::className(), [
                'options' => [
                    'height' => '400px',
                    'margin-top' => '10px',
                ]])->label('Describe your work') ?>
    </div>
</div>