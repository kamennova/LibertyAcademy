<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View
 * @var \app\models\Event $events
 * @var app\models\Trainer $model
 * @var \app\models\Article $articles
 * @var \yii\data\ActiveDataProvider $articleDataProvider
 */

$this->title = 'Update profile | ' . $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Trainers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/css/forms.css');
$this->registerCssFile('/css/register.css');

?>

<div class="update-trainer-profile page-container">
    <h1 class="page-title">Update profile</h1>
    <h2 class="form-section-title">Personal info</h2>

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data',],
        'fieldConfig' => [
            'template' => "<div class='row'><div class='col-lg-12'>{label}\n{input}</div></div>\n<div class='row help-block'>{error}</div>",
            'horizontalCssClasses' => [
                'label' => ''
            ]
        ],
        'encodeErrorSummary' => false]); ?>

    <div class="personal-info-fields">
        <?= $this->render('form_fields/_personal_info_fields', [
            'model' => $model,
            'form' => $form,
        ]); ?>
    </div>

    <h2 class="form-section-title">Contact info</h2>

    <div class="contact-info-fields">
        <?= $this->render('form_fields/_contact_fields', [
            'model' => $model,
            'form' => $form,
        ]); ?>
    </div>
    <div class="links-container centered">
        <?php $url = Url::to(['trainer/delete', 'id' => $model->id]); ?>
        <?= Html::a('Delete profile', $url, [
            'title' => Yii::t('app', 'Delete'),
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete?'),
            'data-method' => 'post',
            'class' => 'delete-profile-link']); ?>
        <?= Html::a("Change password", ['/trainer/change_pass', 'id' => $model->id], ['class' => "change-pass-link"]) ?>
        <?= Html::submitButton('Create', ['class' => 'btn centered']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>