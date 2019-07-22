<?php

use app\models\Country;
use app\models\event\EventType;
use app\models\Tag;
use dosamigos\ckeditor\CKEditor;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\models\Currency;

/* @var $this yii\web\View */
/* @var $model app\models\eVENT */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile('/build/forms.css');
$this->registerCssFile('/build/create-form.css');

$this->registerJsFile('/build/upload_img.js');

?>

<h1 class="page-title form-title"><?= $formTitle ?></h1>

<div class="container event-form-container">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div class='column'>{label}<br>{input}\n<div class='help-block'>{error}</div></div>",
            'labelOptions' => ['class' => 'control-label'],
        ],
        'options' => ['enctype' => 'multipart/form-data'],
        'encodeErrorSummary' => false]); ?>

    <section class="main-info-input event-main-info-input">
        <section class="image-upload">
            <div class="thumbnail event-thumbnail">
                <?= $model->thumb ? "<img src='{$model->thumb}' />" : null ?>
            </div>
            <?= $form->field($model, 'imageFile', [
                'horizontalCssClasses' => [
                    'wrapper' => false,
                    'offset' => false,
                    'label' => '']])
                ->fileInput([
                    'inputTemplate' => "<div class='row'><div class='col-lg-12'>{beginLabel}{labelTitle}\n" .
                        "<div class='col-sm-12'>{input}</div>{endLabel}</div></div>\n<div class='help-block'>{error}</div>"])
                ->label('Featured image') ?>
        </section>
        <div class="row fields-wrapper">
            <div class="col-sm-12 name">
                <?= $form->field($model, 'name', ['horizontalCssClasses' => [
                    'class' => 'form-control name'
                ]])
                    ->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12 event-topics-input">
                <?= $form->field($model, 'tags')
                    ->widget(Select2::class, [
                        'data' => Tag::find()->select('name')->indexBy('id')->column(),
                        'options' => [
                            'placeholder' => 'Select',
                            'class' => 'form-control',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'margin' => '0 8px',
                        ],
                        'showToggleAll' => false]); ?>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="left-field">
            <?= $form->field($model, 'type_id')->dropDownList(EventType::find()->select(['name'])
                ->indexBy('id')->orderBy('name')->column(), ['prompt' => 'select']) ?>
        </div>
        <div class="right-field row">
            <div class="col-sm-6 left-field">
                <?= $form->field($model, 'start')->widget(DateRangePicker::class, [
                    'pluginOptions' => [
                        'autocomplete' => "off",
                        'locale' => ['format' => "YYYY-MM-DD"],
                        'singleDatePicker' => true,
                        'showDropdowns' => true,
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'autocomplete' => "off"
                    ]]) ?>
            </div>
            <div class="col-sm-6 right-field">
                <?= $form->field($model, 'end')->widget(DateRangePicker::class, [
                    'pluginOptions' => [
                        'locale' => ['format' => "YYYY-MM-DD"],
                        'singleDatePicker' => true,
                        'showDropdowns' => true,
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'autocomplete' => "off"
                    ]]) ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'desc')->textarea(['rows' => 3]) ?>

    <div class="row price-fields">
        <div class="col-sm-4">
            <?= $form->field($model, 'price_min')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'price_max')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'currency_id')->dropDownList(Currency::find()->select('currency_name')
                ->indexBy('id')
                ->column(), ['prompt' => 'select']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-5 left-field">
            <?= $form->field($model, 'country_id')->widget(Select2::class, [
                'data' => Country::find()->select(['country_name'])->indexBy('id')->column(),
                'options' => [
                    'placeholder' => 'Select',
                    'class' => 'form-control',
                    'multiple' => false,
                ],
                'pluginOptions' => [
                    'allowClear' => false,
                    'margin' => '0 8px',
                ],
                'showToggleAll' => false]) ?>
        </div>
        <div class="col-sm-7 right-field">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label('City & address') ?>
        </div>
    </div>

    <?= $form->field($model, 'content')->widget(CKEditor::class, [
        'options' => ['height' => 'auto'],
        'preset' => 'standart',
    ]) ?>

    <div class="form-group" align="center">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-create btn-wide' : 'btn btn-wide']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>