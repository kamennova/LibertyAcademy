<?php

use app\models\TrainerCountry;
use app\models\TrainerStatus;
use dosamigos\ckeditor\CKEditor;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Trainer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">
    <div class="update-profile-form">
        <h2 class="page-title">Edit profile</h2>

        <?= Html::errorSummary($model); ?>

        <img src="/img/icons/close.png" style="display: block; margin: 8px auto 25px; width: 30px;"/>

        <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'options' => ['enctype' => 'multipart/form-data'], 'encodeErrorSummary' => false
        , ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Full name') ?>

        <?= $form->field($model, 'email', ['errorOptions' => ['class' => 'help-block', 'encode' => false]])->textInput(['maxlength' => true])->input('email') ?>

        <?= $form->field($model, 'pass')->textInput(['maxlength' => true])->passwordInput() ?>

<!--        --><?//= $form->field($model, 'country')->dropDownList(TrainerCountry::find()->select(['country_name'])->indexBy('id')->column(), ['prompt' => 'select']) ?>

        <?= $form->field($model, 'id_status')->dropDownList(TrainerStatus::find()->select(['name'])->indexBy('id')->column(), ['prompt' => 'select']) ?>

        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

<!--        --><?//= $form->field($model, 'edu')->textarea(['rows' => 6]) ?>

<!--        --><?//= $form->field($model, 'bigthumb')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'big_desc', ['template' => '{label}<br> <div class="row">{input}{error}{hint}</div>'])->textarea(['rows' => 6, 'style' => 'width:100%']) ?>

        <?= $form->field($model, 'org')->textInput(['maxlength' => true]) ?>

<!--        --><?//= $form->field($model, 'desc')->textarea(['rows' => 6]) ?>


        <?= $form->field($model, 'desc')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ]) ?>

        <?= $form->field($model, 'soc_fb')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'soc_tw')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'soc_inst')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'imageFile')->fileInput() ?>

        <?= $form->field($model, 'galleryFiles[]')->fileInput(['multiple' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>





<!--    --><?//= DetailView::widget([
//       'model' => $model,
//        'options' => ['class' => 'view-widget'],
//        'attributes' => [
//            'name',
//            'org',
//            'desc:ntext',
//            'country',
//            'email:email',
//            'thumb',
//            'soc_fb',
//            'soc_inst',
//            'soc_tw',
//            'status',
//            'site',
//            'address',
//            'bigthumb',
//            'big_desc:ntext'
//
//        ],
//
//    ]) ?>


<!--<--<p>-->
    <!--        --><?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn ']) ?>
    <!--        --><?//= Html::a('Delete', ['delete', 'id' => $model->id], [
    //            'class' => 'btn ',
    //            'data' => [
    //                'confirm' => 'Are you sure you want to delete this item?',
    //                'method' => 'post',
    //            ],
    //        ]) ?>
    <!--    </p>