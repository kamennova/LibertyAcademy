<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->registerCssFile('/css/site_index.css');
$this->registerCssFile('/css/subscribe_form.css');
$this->registerJsFile('/js/poster.js', ['depends' => 'yii\web\JqueryAsset']);
$this->title = 'Liberty Academy';

?>

<section class="poster">

    <ul class="poster-slides">
        <li class="slide slide-1 active" id="slide-1">
            <h2 class="slide-title">Go liberty</h2>
            <div class="slide-layer slide-layer-1"></div>
            <div class="slide-layer slide-layer-2"></div>
            <div class="slide-layer slide-layer-3"></div>
            <div class="slide-layer slide-layer-4"></div>
            <p class="slide-caption">
                <?= Html::a('Mosie Trewhitt', ['/trainer/profile', 'id' => 7]) ?> & Nipomo
            </p>
        </li>
        <li class="slide slide-2" id="slide-2">
            <h2 class="slide-title">Go liberty</h2>
            <div class="slide-layer"></div>
            <p class="slide-caption">
                <?= Html::a('Martin Contreras', ['/trainer/profile', 'id' => 1]) ?> & Chiara
            </p>
        </li>
        <li class="slide slide-3" id="slide-3">
            <h2 class="slide-title">Go liberty</h2>
            <div class="slide-layer"></div>
            <p class="slide-caption">
                <?= Html::a('Anna Marciniak', ['/trainer/profile', 'id' => 48]) ?> & Falcao
            </p>
        </li>
    </ul>

    <ul class="slides-indicators">
        <li data-slide-to="1" class="indicator active" id="indicator-1"><span></span></li>
        <li data-slide-to="2" class="indicator" id="indicator-2"><span></span></li>
        <li data-slide-to="3" class="indicator" id="indicator-3"><span></span></li>
    </ul>

</section>

<section class="content-section philosophy" id="philosophy">
    <div class="smaller-container">
        <h2 class="section-title">Philosophy of liberty</h2>
        <h3 class="section-subtitle">Liberty Academy principles</h3>

        <div class="row">
            <div class="col-sm-6">
                <ul class="principles-list positive">
                    <li id="well-being">
                        <span class="icon"></span>
                        <h3 class="principle-name"> Horse's well-being first </h3>
                        <p> Horse's health and needs are always put first before training schedule
                             </p>
                    </li>
                    <li id="education">
                        <span class="icon"></span>
                        <h3 class="principle-name"> Based on positive reinforcement</h3>
                        <p> Training process is based on horse's will to communicate and play </p>
                    </li>
                </ul>
            </div>
            <div class="col-sm-6">
                <ul class="principles-list negative">
                    <li id="sport">
                        <span class="icon"></span>
                        <h3 class="principle-name"> Ammunition shouldn't cause pain</h3>
                        <p> Ammunition (or misuse of it) that causes pain should not be used </p>
                    </li>
                    <li id="discomfort">
                        <span class="icon"></span>
                        <h3 class="principle-name"> No physical punishment</h3>
                        <p> Horse should never be punished for expressing himself</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row goal">
            <p> The goal of liberty training is to establish a true deep connection between the human and the horse.</p>
        </div>
    </div>
</section>

<div class="page-container">
    <section class="content-section guide">
        <h2 class="section-title">Learn liberty</h2>
        <h3 class="section-subtitle">All info in one place</h3>

        <div class="row guide-list">
            <div class="col-sm-4 guide-list-item" id="article-section">
                <span></span>
                <h3><?= Html::a('Articles', ['/article/index']) ?></h3>
                <p>To help you on your way of learning the liberty approach</p>
            </div>
            <div class="col-sm-4 guide-list-item" id="event-section">
                <span></span>
                <h3><?= Html::a('Workshops', ['/event/index']) ?></h3>
                <p>Clinics, webinars, educational book releases and more</p>
            </div>
            <div class="col-sm-4 guide-list-item" id="trainer-section">
                <span></span>
                <h3><?= Html::a('Teachers', ['/trainer/index']) ?></h3>
                <p>Instructors, clinicians, writers and just horse lovers</p>
            </div>
        </div>
    </section>

    <section class="content-section teachers-invitation" id="for-trainers">
        <h2 class="section-title">Join teachers</h2>
        <h3 class="section-subtitle">You are welcome</h3>
        <hr class="article-hr">
        <p> If you are an experienced horse trainer sharing the approach of liberty in horse
            training, you are welcome to join the community! Tell horse people about yourself, post articles and announce clinics
            schedule after registering. <?= Html::a('Find out more', '/site/philosophy') ?></p>
    </section>
</div>

<section class="content-section sign-up">
    <div class="page-container">
        <h2 class="section-title">Sign up to the newsletter!</h2>
        <h3 class="section-subtitle">You'll be glad you did</h3>
        <hr class="content-divider">
        <div class="subscribe-form-container fields-container">

            <?php $form = ActiveForm::begin([
                'id' => 'subscribe-form',
                'layout' => 'inline',
                'fieldConfig' => [
                    'enableLabel' => false,
                    'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                    'horizontalCssClasses' => [
                        'error' => '',
                        'hint' => '',
                    ],
                ], 'enableClientValidation' => false,]); ?>

            <?= $form->field($model, 'first_name')->textInput(['class' => 'form-control conform11', 'placeholder' => 'First name']) ?>

            <?= $form->field($model, 'last_name')->textInput(['class' => 'form-control conform11', 'placeholder' => 'Last name']) ?>

            <?= $form->field($model, 'email')->textInput(['type' => 'email', 'class' => 'form-control conform11', 'placeholder' => 'Email']) ?>

            <?= Html::submitButton('Submit', ['class' => 'btn subscribe-form-btn', 'name' => 'Submit']) ?>

        </div>

        <?php ActiveForm::end(); ?>
</section>

<section class="content-section contacts" id="contact">
    <div class="page-container">
        <h2 class="section-title">Have a question?</h2>
        <h3 class="section-subtitle">Feel free to contact</h3>
        <hr class="article-hr">
        <p> Thanks for your interest in Liberty Academy. If you have any business inquiries or want to leave feedback,
<!--            or             Html::a('become partners', '/site/philosophy#partnership') -->
             drop an email</p>
        <?= Html::a('Leave a message', '/site/contact', ['class' => 'btn btn-center']) ?>
    </div>
</section>