<?php

use app\models\Language;
use app\models\Tag;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

$tagList = Tag::find()->select('name')->indexBy('id')->orderBy('name')->column();

?>

<?php $form = ActiveForm::begin([
    'action' => ['/trainer/myarticles'],
    'method' => 'get',
    'layout' => 'default',
    'options' => ['class' => 'filter-form']
]); ?>

<?= $form->field($model, 'title')->textInput(['placeholder' => 'Title', 'onchange' => 'this.form.submit()'])->label(false) ?>

<?= $form->field($model, 'lang_id')
    ->dropDownList(Language::find()->select('language.lang_name, language.id')
        ->innerJoin('article', 'language.id =  article.lang_id')->distinct()->indexBy('id')->column(),
        ['prompt' => 'Language', 'onchange' => 'this.form.submit()'])->label(false) ?>

<?= $form->field($model, 'tag_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]],
    ['options' => ['class' => 'sort-select-field-2']])
    ->widget(Select2::class, [
        'data' => $tagList,
        'options' => [
            'placeholder' => 'Tags',
            'onchange' => 'this.form.submit()',
            'class' => 'form-control',
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]])->label(false) ?>

<?php ActiveForm::end(); ?>