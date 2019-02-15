<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use app\models\Country;
use app\models\TrainerStatus;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Register';
$this->registerCssFile('/css/register.css');
$this->registerJs("window.onload($('#rulesModal').modal());", \yii\web\View::POS_END);
?>

<div class="container centered register-form-container register-rules">
    <h2 class="page-title">Register</h2>
    <h3 class="form-section-title">Step 1/3: Rules</h3>

    <hr class="content-divider">

    <p class="centered">To join the trainers' community please make sure you agree with liberty philosophy and the rules of
        registration.</p>

    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'options' => [
        'class' => 'trainer-register-form'
        ]
    ]) ?>

    <div class="fields-container">

        <?= $form->field($model, 'no_violence')->checkbox(['label' => 'I never use physical punishment while training horses ']) ?>
        <?= $form->field($model, 'no_bits')->checkbox(['label' => 'I never use ammunition that causes physical pain']) ?>
        <?= $form->field($model, 'no_sports')->checkbox(['label' => 'I always put horse\'s health and needs first']) ?>

    </div>

    <div class="form-group" align="center">
        <?= Html::submitButton('Confirm', ['class' => 'btn btn-wide', 'name' => 'submit-button']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>


