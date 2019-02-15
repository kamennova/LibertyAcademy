<?php

use app\models\Language;
use app\models\Tag;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\web\View;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

$tagList = Tag::find()->select('name')->indexBy('id')->orderBy('name')->column();
$this->registerJsFile('/js/calendar.js', ['position' => View::POS_HEAD]);

?>


<?php $form = ActiveForm::begin([
    'action' => ['/trainer/myevents'],
    'method' => 'get',
    'layout' => 'default',
    'options' => ['class' => 'filter-form']
]); ?>

<?= $form->field($model, 'start')->widget(DatePicker::className(), [
    'name' => 'dp_5',
    'inline' => true,
    'options' => [
        'change' => 'this.form.submit()',
        'yearRange' => '2017'],
    'clientOptions' => [
        'beforeShowDay' => new yii\web\JsExpression('setScheduledDays'),
        'onSelect' => new yii\web\JsExpression('function(){$("#w0").submit();}'),
    ]
])->label(false) ?>

<?= $form->field($model, 'name')->textInput(['placeholder' => 'Name', 'onchange' => 'this.form.submit()'])->label(false) ?>

<?= $form->field($model, 'tag_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]], ['options' => ['class' => 'sort-select-field-2']])
    ->widget(Select2::className(), [
        'data' => $tagList,
        'options' => [
            'placeholder' => 'Topics',
            'onchange' => 'this.form.submit()',
            'class' => 'form-control',
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]])->label(false) ?>


<?php ActiveForm::end(); ?>
