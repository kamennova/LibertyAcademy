<?php

use yii\helpers\Html;

$this->title = 'About LibertyHorseGuide';
$this->registerCssFile('/css/about.css');

?>
<div class="text-container">
<section class="about-academy">
    <h2 class="page-title">About us</h2>

        <p class="entry-p">LibertyHorseGuide is created for horse lovers who want to build a strong relationship with
            their
            horses based on
            trust and respect. The aim is to help you find your teachers, give useful advice and
            keep informed of everything that's happening in liberty horse world.</p>
        <h3 class="section-subtitle">Philosophy</h3>

        <p>Liberty (horsemanship) is a type of horse training technique which is based on positive
            reinforcement and horse's freedom of choice. The goal of liberty training is to establish a true deep
            connection between human and horse.</p>
        <p>
            As Karine Vandenborre said,
            "The goal of Liberty Training is to develop a true
            connection between human and horse... You don´t hold the horse but you give it
            the freedom to leave your side when it feels the need to".

            This enables the horse to not feel any form of pressure or force. Because the main goal of Liberty Training
            is to strongly bond with your horse and for a real connection between you and your horse to arise, and that
            can only occur when the horse feels free to express himself. It is important to convey good intentions, give
            off a right attitude, empathize with the horse and understand his natural characteristics and behavior.
            During Liberty Training you take the time to get to know each other.

            Horses first need the opportunity to become curious about “their human”. Trust and friendship grows from
            there. At liberty we also establish hierarchy and develop our leadershipskills.

            If the horse notices that you can lead him in a grounded, calm and assertive way his trust in you will grow
            even more. Liberty Training is a first step to partnership and natural leadership*
            "Its basic principle is working with a horse which is absolutely free without any means of coercion." ...
            The School strives for utmost development of natural horse`s talents, its mentals and physical
            abilities as well as establishing discipline and understanding in relationships and dialogue with a
            horse. ...The main requirements of Nevzorov Haute Ecole practices are horse`s health, trust, profound
            knowledge of hippology and physiology, feeling of the horse and talent, unreserved acceptence of School
            Interdicta, to keep a horse and provide it quality conditions conforming to school methods of upbringing,
            school membership.

            School postulates: A horse isn`t born for riding and "bits". A horse has a very fragile health. Its sound
            health - a primary foundation of healthy relationships. A horse mustn`t be punished. Any statements on
            behalf of a horse are strictly prohibited." - NHE
            "Whenever there is pain or discomfort for the horse - however slight, there cannot be total trust. Without
            trust, there cannot be a place for learning and understanding." - Sascha Day</p>

</section>
</div>
<section class="learn-liberty">
    <div class="page-container">
        <h2 class="section-title">Learn liberty</h2>
    </div>
</section>

<section class="teachers-info">
    <div class="page-container">
        <h2 class="section-title">Join teachers</h2>
        <div class="row">
            <div class="col-sm-6 text-column">
                <p>Every experienced horseman sharing the view of liberty horse training method is welcome to join the
                    community! Post articles, announce workshops and let the world know about you.<br>
                    Please check out the rules:
                </p>
                <ul>
                    <li>Education based on horse's willing to communicate and play</li>
                    <li>Not using force</li>
                    <li>Not using bits</li>
                    <li>Not taking part in traditional horse sports</li>
                </ul>
                <?= Html::a('Join', '/trainer/register', ['class' => 'btn']) ?>
            </div>
            <div class="col-sm-6" align="center">
                <img src="/img/cleverhans.jpg"/>
            </div>
        </div>
    </div>
</section>
<section class="partnership" id="partnership">
    <div class="page-container">
        <h2 class="section-title" style="text-align: center">Partnership</h2>
        <div class="row">
            <div class="col-sm-7">

                <p>
                    If you are a horse-related organization supporting liberty method, we are interested in partnership
                    with you. Partnership assumes mutual placing links to partner's website on own's website.
                </p>
            </div>
            <div class="col-sm-5">
                <img src="/img/logo.png"/>
                <img src="/img/icons/64.svg"/>
            </div>
        </div>

        <?= Html::a('Leave a request', '/site/contact', ['class' => 'btn']) ?>
    </div>
</section>
<!--    <p>There are 4 rules for liberty horse trainers who want to join the community</p>-->
<!--    <ul class="liberty-means clearfix">-->
<!--        <li id="liberty-education">-->
<!--            <p>Education based on horse's willing to communicate and play</p>-->
<!--        </li>-->
<!---->
<!--        <li id="liberty-without-force">-->
<!--            <p>Not using force</p>-->
<!--        </li>-->
<!---->
<!--        <li id="liberty-without-bits">-->
<!--            <p>Not using bits</p>-->
<!--        </li>-->
<!---->
<!--        <li id="liberty-without-sports">-->
<!--            <p>Not taking part in traditional horse sports</p>-->
<!--        </li>-->
<!--    </ul>-->

