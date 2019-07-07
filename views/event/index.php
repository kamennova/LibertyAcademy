<?php

use app\models\Country;
use app\models\event\EventType;
use app\models\Tag;
use app\models\Trainer;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View
 * @var ActiveDataProvider $provider
 * @var app\models\Event $events
 * @var app\models\event\EventCondition $condition
 */
$this->title = 'Events | Liberty Academy';

$this->registerCssFile('/css/list_layout.css');
$this->registerCssFile('/css/event_index.css');

//-----

$events = $provider->getModels();

$smallThumbsQuery = clone $provider->query;
$smallThumbs = $smallThumbsQuery->select('thumb')->andwhere('thumb<>""')->limit(3)->column();
$smallThumbsNumber = count($smallThumbs);

//------

$curatorsNameList = Trainer::find()
    ->select(["CONCAT(trainer.name, ' ', trainer.surname)", 'trainer.id'])
    ->innerJoin('event', 'trainer.id =  event.trainer_id')
    ->distinct()
    ->indexBy('id')
    ->column();

$countryListSubQuery = (new \yii\db\Query())
    ->select(['country_id'])
    ->from('event')
    ->distinct();

$countryList = Country::find()->select('country_name')->where(['in', 'id', $countryListSubQuery])
    ->indexBy('id')->orderBy('id')->column();

$eventsNumber = $provider->pagination->totalCount;

$workshopDates = [];
?>

<div class="site-container flex-container">
    <aside class="filter-column workshop-filter-column">
        <div class="filter-column-top">
            <?php if ($events) {
                $smallThumbsList = '';

                foreach ($smallThumbs as $smallThumb) {
                    $smallThumbsList .= "<li class='small-thumb'><img src='{$smallThumb}'/></li>";
                }

                if ($eventsNumber != 0 && $eventsNumber < 3 && $smallThumbsNumber < $eventsNumber) {
                    for ($i = 0; $i < $eventsNumber; $i++) {
                        $smallThumbsList .= "<li class='small-thumb'></li>";
                    }
                };

                if ($smallThumbsList !== '') { ?>
                    <ul class="small-thumbs-list events-thumbs-list">
                        <?= $smallThumbsList ?>
                    </ul>
                <?php }
            } ?>

            <span class="number events-number">
                <?= $eventsNumber . ' event' . (($eventsNumber !== 1) ? 's' : null) ?>
            </span>
        </div>

        <h1 class="filter-title">Filter by</h1>

        <div class="fields-container">
            <?php $form = ActiveForm::begin([
                'action' => Url::to(['event/index']),
                'layout' => 'default',
                'method' => 'GET',
                'options' => ['class' => 'filter-form']
            ]); ?>

            <?= $form->field($condition, 'country_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]],
                ['options' => ['class' => 'sort-select-field']])
                ->dropDownList($countryList, ['prompt' => 'Country', 'onchange' => 'this.form.submit()'])->label(false) ?>

            <?= $form->field($condition, 'type_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]],
                ['options' => ['class' => 'sort-select-field-2']])
                ->dropDownList(EventType::find()->select(['name'])->indexBy('id')->distinct()->column(),
                    ['prompt' => 'Type', 'onchange' => 'this.form.submit()'])->label(false) ?>

            <?= $form->field($condition, 'trainer_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]])
                ->dropDownList($curatorsNameList, [
                    'prompt' => 'Held by',
                    'onchange' => 'this.form.submit()',
                    'placeholder' => 'Curator'])->label(false) ?>

            <?= $form->field($condition, 'tag_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]])
                ->widget(Select2::class, [
                    'data' => Tag::find()
                        ->select('name')
                        ->indexBy('id')
                        ->column(),
                    'options' => [
                        'placeholder' => 'Topics',
                        'onchange' => 'this.form.submit()',
                        'class' => 'form-control',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'margin' => '0 8px',
                    ],
                ])
                ->label(false); ?>

            <?php ActiveForm::end(); ?>
        </div>

        <?= Html::a('Clear all filters', ['/event/index'], ['class' => 'clear-filter']) ?>

    </aside>

    <section class="events-grid main-grid">
        <?= $eventsNumber == 0 ? '<p class="nothing-found-message">No events found :-(</p>' : '<ul class="events-list">' ?>

        <?php foreach ($events

                       as $event) {

            ?>

            <li class="item event-item">
                <section class="event-info">
                    <div class="thumb"> <?= $event->thumb ? "<img src='$event->thumb' />" : null ?> </div>
                    <div class="event-content">

                        <?php if ($event->tags) { ?>

                            <ul class='event-topics'>

                                <?php $topicsNewList = '';
                                foreach ($event->tags as $tag) {
                                    $topicsNewList .= '<li class="topic">' . $tag->name . '</li> ';
                                } ?>

                                <?= $topicsNewList ?> </ul>
                        <?php } ?>

                        <h2 class="name item-name event-name">
                            <?php Html::a($event->name, ['/event/view', 'id' => $event->id]) ?>
                        </h2>

                        <ul class="event-options">
                            <?= $event->address ? '<li class="event-address">' . $event->address . '</li>' : null ?>

                            <li class="event-curator">
                                <?php Html::a($event->trainer->fullName, ['/trainer/profile', 'id' => $event->trainer->id]) ?>
                            </li>

                            <?php if (!is_null($event->priceHtmlString)) {
                                echo "<li class='event-price'>" . $event->priceHtmlString . "</li>";
                            } ?>
                        </ul>

                        <?= "<p class='event-desc'>$event->desc</p></div></section>" ?>

                        <section class="event-dates">

                        <span class="date start-date">
                            <span class="day"> <?= Yii::$app->formatter->asDate($event->start, 'php:d') ?> </span>
                            <span class="month"> <?= Yii::$app->formatter->asDate($event->start, 'php:M') ?> </span>
                        </span>

                            <?php if ($event->end) { ?>
                                <span class="dash"></span>
                                <span class="date end-date">
                                    <span class="day"> <?= Yii::$app->formatter->asDate($event->end, 'php:d') ?> </span>
                                <span class="month"> <?= Yii::$app->formatter->asDate($event->end, 'php:M') ?> </span>
                                </span>
                            <?php } ?>

                        </section>
            </li>

        <?php } ?>
        <?= $events ? '</ul>' : null ?>

        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $provider->pagination,
        ]) ?>

    </section>
</div>