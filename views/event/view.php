<?php

/** @var array $thumbs
 * @property \app\models\Event $event
 */

use app\models\Event;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var Event $event */
$trainer = $event->trainer;

$this->title = $event->name . ' | Liberty Academy';

$this->registerMetaTag(['name' => 'keywords', 'content' =>
    strtolower($event->name) . ', ' . strtolower($trainer->fullName) . ', ' .
    'liberty academy, liberty training, liberty horse, liberty horsemanship, liberty horse training, liberty horse event']);
$this->registerMetaTag(['name' => 'description', 'content' => $event->desc]);
$this->registerMetaTag(['og:title' => $this->title]);
$this->registerMetaTag(['og:type' => 'website']);
$this->registerMetaTag(['og:description' => $event->desc]);

$this->registerCssFile('/build/site.css');
$this->registerCssFile('/build/profile.css');
$this->registerJs('$(".big-description p:has(img)").addClass("image-p")');

//-----------

$tagList = ''; // $event topics
if ($event->tags) {
    $tagList = '<ul class="services-list">';
    foreach ($event->tags as $tag) {
        $tagList .= "<li class='service-item'>" . $tag->name . '</li>';
    }
    $tagList .= '</ul>';
}

//------------

$country = $event->country ? '<h3 class="location event-location">' . $event->country->country_name . '</h3>' : null;
$start_date_label = $event->end ? 'Start date' : 'Date';
$endDate = $event->end ? Yii::$app->formatter->asDate($event->end, 'php:d M') : null;

?>

<div class="site-container profile">

    <section class="profile-top event-profile-top">
        <div class="main-thumbnail event-main-thumbnail">
            <?= ($event->thumb <> '') ? "<img src='$event->thumb' alt='$event->name' />" : null ?>
        </div>

        <h1 class="name event-name"><?= $event->name ?></h1>
        <?= $country ?>
        <?= $tagList ?>

        <blockquote class="short-description event-short-description">
            <?= $event->desc ?>
        </blockquote>
    </section>

    <section class="main-info event-main-info">
        <?php echo DetailView::widget([
            'model' => $event,
            'template' => function ($attribute) {
                if (!($attribute['attribute'] == 'price_min' && !isset($event->price_min)) &&
                    isset($attribute['value']) && $attribute['value'] !== '' && $attribute['value'] !== ' ') {
                    return "<div class='info-item'><label class='item-label'>{$attribute['label']}</label>" .
                        "<br><strong class='item-value'>{$attribute['value']}</strong></div>";
                }
            },
            'attributes' => [
                [
                    'attribute' => 'location',
                    'label' => 'Location',
                    'value' => $event->location
                ],
                [
                    'attribute' => 'trainer_id',
                    'label' => 'Held by',
                    'value' => Html::a($trainer->fullName, ['trainer/profile', 'id' => $trainer->id]),
                ],
                [
                    'attribute' => 'start',
                    'label' => $start_date_label,
                    'value' => Yii::$app->formatter->asDate($event->start, 'php:d M Y')
                ],
                [
                    'attribute' => 'end',
                    'value' => $endDate
                ],
                [
                    'attribute' => 'type_id',
                    'value' => $event->type->name == 'Other' ? null : $event->type->name
                ],
                [
                    'attribute' => 'price',
                    'value' => $event->priceHtmlString,
                ],
            ],
        ]); ?>
    </section>

    <?php if ($event->content) {
        echo
            '<section class="big-description event-big-description">' .
            '<h3 class="item-label">About event</h3>' .
            '<p>' .
            $event->content .
            '</section>';
    } ?>

</div>