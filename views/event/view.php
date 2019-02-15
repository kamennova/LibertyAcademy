<?php

/** @var array $thumbs
 * @property \app\models\Event $event
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$trainer = $event->trainer;

$this->registerCssFile('/css/profile.css');

$this->title = $event->name . ' | Liberty Academy';

$this->registerJs('$("p:has(img)").addClass("image-p")');

//-----------

$tagList = ''; // $event topics
if ($event->tags) {
    $tagList = '<ul class="services-list">';
    foreach ($event->tags as $tag) {
        $tagList .= "<li class='service-item'>" . $tag->name . '</li>';
    }
    $tagList .= '</ul>';
}

//-----------

$location = ''; // where based
$event->address ? $location = "$event->address, " : null;
$event->country->country_name ? $location .= $event->country->country_name : null;

//------------

$endDate = $event->end ? Yii::$app->formatter->asDate($event->end, 'php:d M') : null;

?>

<div class="site-container profile">

    <section class="profile-top event-profile-top">
        <div class="main-thumbnail event-main-thumbnail">
            <?= ($event->thumb <> '') ? "<img src='$event->thumb' />" : null ?>
        </div>

        <h1 class="name event-name"><?= $event->name ?></h1>
        <h3 class="location event-location"><?= $location ?></h3>
        <?= $tagList ?>

        <blockquote class="short-description event-short-description">
            <?= $event->desc ?>
        </blockquote>
    </section>

    <section class="main-info event-main-info">
        <?php echo DetailView::widget([
            'model' => $event,
            'template' => function ($attribute, $index, $widget) {
                if (isset($attribute['value']) && $attribute['value'] !== '' && $attribute['value'] !== ' ') {
                    return "<div class='info-item'><label class='item-label'>{$attribute['label']}</label><br><strong class='item-value'>{$attribute['value']}</strong></div>";
                }
            },
            'attributes' => [
                [
                    'attribute' => 'location',
                    'label' => 'Location',
                    'value' => $location
                ],
                [
                    'attribute' => 'trainer_id',
                    'value' => Html::a($trainer->fullName, ['trainer/profile', 'id' => $trainer->id])

                ],
                [
                    'attribute' => 'start',
                    'value' => Yii::$app->formatter->asDate($event->start, 'php:d M Y')
                ],
                [
                    'attribute' => 'end',
                    'value' => $endDate
                ],
                [
                    'attribute' => 'type_id',
                    'value' => $event->type->name

                ],
                [
                    'attribute' => 'price',
                    'value' => $event->fullPrice->currency_symbol . $event->price
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
