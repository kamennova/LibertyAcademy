<?php

/**
 * @var \app\models\Trainer $trainer
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $trainer->name . ' ' . $trainer->surname . ' | Liberty Academy';

$meta_desc = $trainer->mainInfoStr . ' | "' . $trainer->desc . '"';

$this->registerMetaTag(['name' => 'keywords', 'content' =>
    strtolower($trainer->name) . ', ' . strtolower($trainer->location) . ' liberty' .
    ', liberty academy, liberty training, liberty trainers, liberty trainer, liberty horse, liberty horsemanship, liberty horse training']);
$this->registerMetaTag(['name' => 'description', 'content' => $meta_desc]);
$this->registerMetaTag(['og:title' => $this->title]);
$this->registerMetaTag(['og:type' => 'profile']);
$this->registerMetaTag(['og:description' => $meta_desc]);

$this->registerCssFile('/build/profile.css');
$this->registerJs(' $(".big-description p:has(img)").addClass("image-p");');

// --- Trainer main info ---

$countryList = ''; // where teaching
foreach ($trainer->teachCountries as $country) {
    $countryList .= Html::a($country->country_name, ['trainer/index', 'TrainerCondition[teachcountry_id]' => $country->id]) . ', ';
}
$countryList = substr($countryList, 0, -2);

$serviceList = ''; // services $trainer provides
if ($trainer->services) {
    $serviceList = '<ul class="services-list">';
    foreach ($trainer->services as $service) {
        $serviceList .= "<li class='service-item'>" . $service->service_name . '</li>';
    }
    $serviceList .= '</ul>';
}

$languageList = ''; // languages $trainer speaks
if ($trainer->languages) {
    $languageList = '<ul class="languages-list">';
    foreach ($trainer->languages as $language) {
        $lang_flag = $language->lang_flag == '' ? $language->lang_code : $language->lang_flag;
        $languageList .= "<li><img class='lang-icon' alt='$language->lang_code' src='/img/flags/$lang_flag.svg' />" . $language->lang_name . '</li>';
    }
    $languageList .= '</ul>';
}

$websitesList = ''; // $trainer's web pages
if ($trainer->soc_fb || $trainer->soc_tw || $trainer->soc_inst) {
    $websitesList = '<ul class="trainer-pages-list">';

    $trainer->soc_fb ? $websitesList .=
        '<li class="page-item facebook">' . Html::a('<span>Facebook</span>', "$trainer->soc_fb") . '</li>' : null;
    $trainer->soc_inst ? $websitesList .=
        '<li class="page-item instagram">' . Html::a('<span>Instagram</span>', "$trainer->soc_inst") . '</li>' : null;
    $trainer->soc_tw ? $websitesList .=
        '<li class="page-item twitter">' . Html::a('<span>Twitter</span>', "$trainer->soc_tw") . '</li>' : null;

    $websitesList .= '</ul>';
}

?>

<div class="site-container profile">

    <section class="profile-top trainer-profile-top">
        <div class="main-thumbnail trainer-main-thumbnail">
            <?= ($trainer->thumb <> '') ? "<img alt='$trainer->fullName' src='$trainer->thumb' />" : null ?>
        </div>

        <h1 class="name trainer-name"><?= $trainer->name . ' ' . $trainer->surname ?></h1>
        <h3 class="location trainer-location"><?= $trainer->trainerHomeCountry->country_name ?></h3>
        <?= $serviceList ?>

        <blockquote class="short-description trainer-short-description">
            <?= $trainer->desc ?>
        </blockquote>
    </section>

    <section class="main-info trainer-main-info">
        <?= DetailView::widget([
            'model' => $trainer,
            'template' => function ($attribute) {
                if (isset($attribute['value']) && $attribute['value'] !== '' && $attribute['value'] !== ' ') {
                    return "<div class='info-item'><label class='item-label'>{$attribute['label']}</label>" .
                        "<strong class='item-value'>{$attribute['value']}</strong></div>";
                }

                return null;
            },
            'attributes' => [
                [
                    'attribute' => 'org',
                ],
                [
                    'attribute' => 'location',
                    'label' => 'Based in',
                    'value' => $trainer->location
                ],
                [
                    'attribute' => 'teachCountries',
                    'value' => $countryList,
                    'label' => 'Teaching in'
                ],
                [
                    'attribute' => 'languages',
                    'value' => $languageList,
                    'label' => 'Speaks'
                ],
            ],
        ]) ?>
    </section>

    <?php if ($trainer->big_desc) {
        echo
            '<section class="big-description trainer-big-description">' .
            '<h3 class="item-label">About teacher</h3>' .
            $trainer->big_desc .
            '</section>';
    } ?>

    <section class="actions trainer-actions">

        <?= $articles ? Html::a("Read articles",
            ['/article/index', 'ArticleCondition[trainer_id]' => $trainer->id],
            ['class' => 'action-item trainer-articles']) : null ?>

        <?= $events ? Html::a("View events",
            ['/event/index', 'EventCondition[trainer_id]' => $trainer->id],
            ['class' => 'action-item trainer-events']) : null ?>

        <?= $trainer->site ? Html::a("Visit website",
            "$trainer->site",
            ['class' => 'action-item trainer-website']) : null ?>

    </section>

    <?php if ($websitesList <> '') { ?>
        <section class="trainer-pages">
            <p> <?= $trainer->name ?> elsewhere: </p>
            <?= $websitesList ?>
        </section>
    <?php } ?>

    <?php /** @var \app\models\Event $upcomingEvent */
    if ($upcomingEvent) { ?>

        <article class="modal upcoming-event modal-show" id="upcoming-event-modal">
        <span class="modal-close">
            <span class="visually-hidden">Close</span>
            &#215
        </span>
            <div class="event-thumb">

                <?php if ($upcomingEvent->thumb != '') {
                    echo "<img alt='$upcomingEvent->name' src='$upcomingEvent->thumb' />";
                } ?>

            </div>
            <h2 class="modal-title item-label info-item-label">Upcoming event</h2>
            <h3 class="event-name"> <?= $upcomingEvent->name ?> </h3>
            <p class="date">
                <span class="day month"><?= $upcomingEvent->start ?></span>
                <?php if ($upcomingEvent->end) { ?>
                    -
                    <span class="day"><?= $upcomingEvent->end ?></span>
                <?php } ?>
            </p>
        </article>

    <?php } ?>
</div>