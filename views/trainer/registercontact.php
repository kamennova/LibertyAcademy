<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\RegisterTrainer */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register | Liberty Academy';

$this->registerCssFile('/build/trainer_forms.css');

?>

<div class="container register-form-container register-contact">

    <h1 class="page-title">Register</h1>
    <h2 class="form-section-title">Step 3/3: Contact info</h2>

    <?php $form = ActiveForm::begin([
        'action' => ['/trainer/registercontact'],
        'layout' => 'horizontal',
        'options' => [
            'class' => 'trainer-register-form contact-info-fields'
        ],
        'fieldConfig' => [
            'template' => "{label}\n{input}\n<div class='row help-block'>{error}</div>",
            'horizontalCssClasses' => [
                'label' => ''
            ]
        ],
        'encodeErrorSummary' => false
    ]); ?>

    <?= $this->render('form_fields/_contact_fields', [
        'model' => $model,
        'form' => $form,
    ]) ?>

    <div class="form-group" align="center">
        <?= Html::a('Back', ['/trainer/registerpersonal'], ['class' => 'btn btn-wide']) ?>

        <?= Html::submitButton('Submit', ['class' => 'btn btn-wide', 'name' => 'submit-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>