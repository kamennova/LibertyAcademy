<?php

use app\models\Country;
use app\models\event\EventType;
use app\models\Tag;
use dosamigos\ckeditor\CKEditor;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\eVENT */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile('/css/forms.css');
$this->registerCssFile('/css/create-form.css');

?>

<h1 class="page-title form-title"><?= $formTitle ?></h1>

<div class="container event-form-container">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div class='row'><div class='col-lg-12'>{label}</div></div><div class='row'><div class=\"col-lg-12\">{input}</div></div>\n<div class='help-block'>{error}</div>",
            'labelOptions' => ['class' => 'control-label'],
        ],
        'options' => ['enctype' => 'multipart/form-data'],
        'encodeErrorSummary' => false]); ?>

    <section class="main-info-input event-main-info-input">
        <section class="image-upload">
            <div class="thumb event-thumb">
                <?= $model->thumb ? "<img src='{$model->thumb}' />" : null ?>
            </div>
            <?= $form->field($model, 'imageFile', [
                'horizontalCssClasses' => [
                    'wrapper' => false,
                    'offset' => false,
                    'label' => '']])
                ->fileInput([
                    'inputTemplate' => "<div class='row'><div class='col-lg-12'>{beginLabel}{labelTitle}\n<div class='col-sm-12'>{input}</div>{endLabel}</div></div>\n<div class='help-block'>{error}</div>"])
                ->label('Featured image') ?>
        </section>
        <div class="row fields-wrapper">
            <div class="col-sm-12 name">
                <?= $form->field($model, 'name', ['horizontalCssClasses' => [
                    'class' => 'form-control name'
                ]
//                'template' => '<div class="row" ><div class="col-sm-2">{label}</div><div class="col-lg-10">{input}{error}{hint}</div></div>'
                ])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-12 event-topics-input">
                <?= $form->field($model, 'tags', []
//                'template' => '<div class="row"><div class="col-sm-2">{label}</div><div class="col-lg-10">{input}{error}{hint}</div></div>']
                )
                    ->widget(Select2::className(), [
                        'data' => Tag::find()->select('name')->indexBy('id')->column(),
                        'options' => [
                            'placeholder' => 'Select',
                            'class' => 'form-control',
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'margin' => '0 8px'

                        ],
                    ])->label('Topics'); ?>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-sm-6 left-field">
            <?= $form->field($model, 'type_id')->dropDownList(EventType::find()->select(['name'])->indexBy('id')->orderBy('name')->column(), ['prompt' => 'select']) ?>
        </div>
        <div class="col-sm-6 row">
            <div class="col-sm-6 left-field">
                <?= $form->field($model, 'start')->widget(DateRangePicker::className(), [
                    'name' => 'date_range_4',
//            'useWithAddon' => true,
                    'pluginOptions' => [
                        'singleDatePicker' => true,
                        'showDropdowns' => true
                    ]
                ]) ?>
            </div>
            <div class="col-sm-6 right-field">
                <?= $form->field($model, 'end')->textInput() ?>
            </div>
        </div>
    </div>
    <?= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'for')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-sm-5 left-field">
            <?= $form->field($model, 'country_id')->dropDownList(Country::find()->select(['country_name'])->indexBy('id')->column(), ['prompt' => 'select']) ?>
        </div>
        <div class="col-sm-7 right-field">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($model, 'content', ['template' => '{label}<br><br><div class="row" ><div class="col-lg-12">{input}{error}{hint}</div></div>'])
        ->widget(CKEditor::className(), [
            'options' => ['height' => 'auto'],
            'preset' => 'basic'
        ]) ?>

    <div class="form-group" align="center">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-create btn-wide' : 'btn btn-wide']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

