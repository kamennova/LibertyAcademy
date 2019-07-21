<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\RegisterTrainer */

use app\models\Language;
use app\models\Service;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;

$this->registerJsFile('/build/upload_img.js');

?>

    <div class="image-upload column">
        <div class="thumbnail">
            <?= $model->thumb ? "<img src='$model->thumb' />" : null ?>
        </div>
        <?= $form->field($model, 'imageFile')->fileInput([
            'class' => 'input-hidden']) ?>
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
            ->widget(Select2::class, [
                'data' => Service::find()->select('service_name')->indexBy('id')->column(),
                'options' => [
                    'class' => 'form-control',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'showToggleAll' => false,
            ])->label("Services you provide"); ?>
    </div>
    <div class="col-sm-6 right-field">
        <?= $form->field($model, 'languages')
            ->widget(Select2::class, [
                'data' => Language::find()->select('lang_name')->indexBy('id')->column(),
                'options' => [
                    'class' => 'form-control',
                    'multiple' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'showToggleAll' => false,
            ])->label('Languages you speak'); ?>
    </div>
</div>

<div class="column">
    <div class="col-sm-12 description-column">

        <?= $form->field($model, 'desc')->textarea(['maxlength' => true, 'rows' => 2])->label('Describe your approach shortly (150 symbols)') ?>

        <?= $form->field($model, 'big_desc')
            ->widget(CKEditor::class, [
                'options' => [
                    'height' => '400px',
                    'margin-top' => '10px',
                ]])->label('Tell about yourself') ?>
    </div>
</div>