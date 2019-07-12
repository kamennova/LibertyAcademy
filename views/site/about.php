<?php

use yii\helpers\Html;

$this->title = 'About | Liberty Academy';

?>
<div class="text-container">
    <section class="about-academy">
        <h2 class="page-title">About project</h2>
        <p class="entry-p">
            Liberty Academy is a project aimed to popularize liberty approach in horsemanship as a way to build a strong
            human-horse connection based on mutual trust and respect. The platform gives teachers of liberty
            horsemanship
            opportunity to share their approach, announce events and post articles. </p>

        <h3>What is liberty training? </h3>
        <p>Liberty (horsemanship) is a type of horse training approach based on positive
            reinforcement and horse's freedom of choice. The goal of liberty training is to establish a friendly
            connection between human and horse.</p>

        <h3>I'm a teacher, how can I join?</h3>
        <p>If you are skilled in liberty horsemanship, you
            may <?= Html::a('join the community', ['/trainer/register']) ?> of teachers. <br>A teacher
            at Liberty Academy
        </p>
        <ul>
            <li> always puts horse's health and needs first before training schedules</li>
            <li> never uses physical punishment, nor he/she uses ammunition (in the way) that causes pain</li>
            <li> gives the horse freedom of choice during training, e.g. the horse chooses to be by person's side</li>
        </ul>

        <p class="warning">Profiles, events or articles with content contradictory to principles of liberty horsemanship
            will be deleted without their authors being notified.</p>
    </section>
</div>