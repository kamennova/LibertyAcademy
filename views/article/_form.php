<?php

use app\models\Language;
use app\models\Tag;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\article\ArticleForm */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile('/build/site.css');
$this->registerCssFile('/build/forms.css');
$this->registerCssFile('/build/create-form.css');

$this->registerJsFile('/build/upload_img.js');

$default_lang_id = 1; // English

?>

<div class="container article-form-container">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div class='column'>{label}<br>{input}\n<div class='help-block'>{error}</div></div>"
        ],
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
        'encodeErrorSummary' => false]); ?>

    <section class="main-info-input article-main-info-input">
        <section class="image-upload">
            <div class="article-thumbnail thumbnail">
                <?= $model->thumb ? "<img src='{$model->thumb}' />" : null ?>
            </div>
            <?= $form->field($model, 'imageFile', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false,
                'label' => '']])->fileInput()->label('Featured image') ?>
        </section>
        <div class="row name">
            <?= $form->field($model, 'title')->textarea([
                'maxlength' => true,
                'placeholder' => 'Title',
                'class' => 'form-control article-title autosize',
            ])->label(false) ?>
        </div>
    </section>

    <div class="row">
        <div class="col-sm-8 left-field article-tags-input">
            <?= $form->field($model, 'tags')
                ->widget(Select2::class, [
                    'data' => Tag::find()->select('name')->indexBy('id')->column(),
                    'options' => [
                        'placeholder' => 'Tags',
                        'class' => 'form-control article-tags-input',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'margin' => '0 8px',
                    ],
                    'showToggleAll' => false,
                ])->label('Tags'); ?>
        </div>
        <div class="col-sm-4 right-field">
            <?= $form->field($model, 'lang_id')->dropDownList(Language::find()->select(['lang_name'])
                ->indexBy('id')->column(), ['prompt' => 'select', 'value' => $default_lang_id]) ?>
        </div>
    </div>

    <div class="article-content-input">
        <?= $form->field($model, 'content')->widget(CKEditor::class, [
            'preset' => 'standart',
            'clientOptions' => [
                'min-height' => '500px',
            ]]) ?>
    </div>

    <div class="form-group" align="center">
        <?= Html::submitButton($model->isNewRecord ? 'Publish' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-create btn-tick' : 'btn btn-tick']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>