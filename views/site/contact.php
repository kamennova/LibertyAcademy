<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/build/site.css');
$this->registerCssFile('/build/sort-by-form.css');

function generate_horsey()
{
    $horsey_num = rand(1, 6);

    return "url(/img/icons/temp/{$horsey_num}.svg);";
}

?>
<div class="site-contact event-sort">
    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>
    <span class="horsey-divider" style="background-image: <?= generate_horsey() ?>"></span>
    <div class="page-container">
        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

            <div class="alert alert-success">
                Thank you for contacting us. We will respond to you as soon as possible.
            </div>

        <?php else: ?>

            <p class="centered">
                If you have business inquiries or other questions, please fill out the following form to contact us.
                Thank you.
            </p>

            <div class="row form-container">

                <?php $form = ActiveForm::begin(['id' => 'contact-form', 'layout' => 'horizontal', 'fieldConfig' => [
                    'enableLabel' => false,
                    'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'wrapper' => 'col-sm-12',
                        'error' => '',
                        'hint' => '',
                    ],
                ], 'enableClientValidation' => false,]); ?>

                <div class="row">
                    <div class="col-sm-6 left-field">
                        <?= $form->field($model, 'name')->textInput(['class' => 'form-control conform11', 'placeholder' => 'Name']) ?>
                    </div>
                    <div class="col-sm-6 right-field">
                        <?= $form->field($model, 'email')->textInput(['type' => 'email', 'class' => 'form-control conform11', 'placeholder' => 'Email']) ?>
                    </div>
                </div>
                <?= $form->field($model, 'subject')->textInput(['class' => 'form-control conform11', 'placeholder' => 'Subject']) ?>

                <?= $form->field($model, 'body')->textArea(['rows' => 8, 'style' => 'width: 100%;
                         ', 'placeholder' => 'Message']) ?>

                <div class="form-group" align="center">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-wide', 'name' => 'submit-btn']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

        <?php endif; ?>
    </div>
</div>