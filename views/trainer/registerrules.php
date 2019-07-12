<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegisterTrainer */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register | Liberty Academy';
$this->registerCssFile('/build/register.css');

?>

<div class="container centered register-form-container register-rules">
    <h2 class="page-title">Register</h2>
    <h3 class="form-section-title">Step 1/3: Rules</h3>
    <hr class="content-divider">

    <p class="centered">To join the teachers' community please make sure you agree with liberty principles and the rules of
        registration.</p>

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'options' => [
        'class' => 'trainer-register-form'
        ]
    ]) ?>

    <div class="fields-container">
        <?= $form->field($model, 'needs_first')->checkbox(['label' => 'I always put horse\'s health and needs first']) ?>
        <?= $form->field($model, 'no_violence')->checkbox(['label' =>
            "I never use physical punishment, nor I use ammunition the way that causes pain"]) ?>
        <?= $form->field($model, 'choice')->checkbox(['label' => 'I give the horse freedom of choice during training process']) ?>
    </div>

    <div class="form-group" align="center">
        <?= Html::submitButton('Confirm', ['class' => 'btn btn-wide', 'name' => 'submit-button']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>