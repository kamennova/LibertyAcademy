<?php

use yii\helpers\Html;

$this->title = 'Internship';

?>
<style>
    p {
        font-family: "Open Sans", Arial, sans-serif;
        font-size: 17px;
        line-height: 1.8;
    }

    .padding-page-container {
        padding-bottom: 40px;
    }

    .nice-p::first-letter {
        /*font-family: Lato, Arial, sans-serif;*/
        /*font-size: 25px;*/
        /*color: rgba(0, 0, 0, 0.8);*/
        /*font-weight: 700;*/
        /*letter-spacing: 1px;*/
    }

    .image {
        border-radius: 16px;
    }

    .centered-image {
        display: block;
        margin: 20px auto;
        text-align: center;

        /*width: 50%;*/
    }
</style>
<div class="page-container padding-page-container">
    <h1 class="page-title">Internship</h1>

    <p class="nice-p">Stina’s center is in the Caribbean and she is regularly looking for working students and interns,
        who want to
        spend
        at least two months or more
        at <?= Html::a('Richmond Vale Nature, Diving and Hiking Center', 'http://www.richmondvalehiking.com') ?>
        taking care of the small herd of 5 former wild horses.

        The life at the center is has a variety of tasks like grooming, fixing fences, trimming, training horses and
        picking
        up manure for the organic garden. As our center is sited very remote you can experience a sort of freedom up
        here
        that is difficult to find in more colonized areas.

        <?= Html::a('Read more', 'http://stinaherberg.com/internship/') ?> about the possibilities and expectations of
        becoming a working student at SVG Horse School.
    </p>

    <img src="../img/internship.jpg" class="image centered-image"/>
</div>

