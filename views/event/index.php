<?php

use app\models\Country;
use app\models\Event;
use app\models\event\EventType;
use app\models\Tag;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use \app\models\Trainer;
use yii\jui\DatePicker;
use yii\web\View;


/* @var $this yii\web\View
 * @var ActiveDataProvider $provider
 * @var app\models\Event $events
 * @var app\models\event\EventCondition $condition
 */
$this->title = 'Events | Liberty Academy';

$js = '

var seminarDays = [[7, 16, 2017], [06, 10, 2017], [6, 6, 2017],[5, 7, 2017],[8, 17, 2017],[9, 1, 2017], [10, 15, 2017]];

function setScheduledDays(date) {

	for (i = 0; i < seminarDays.length; i++) { 
      if (date.getMonth() == seminarDays[i][0] - 1 && date.getDate() == seminarDays[i][1]  && date.getFullYear() == seminarDays[i][2] ) { 
        return [true, \'sDay\']; 
      } 
   } 
 
  return [false, \'\'];
}
';

$removeCurrentDay = '

$(".ui-datepicker-inline").find(".ui-datepicker-current-day").removeClass("ui-datepicker-current-day");

';


$this->registerJs($js, View::POS_HEAD);
$this->registerJs($removeCurrentDay, View::POS_END);

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

$countryList = Country::find()->select('country_name')->where(['in', 'id', $countryListSubQuery])->indexBy('id')->orderBy('id')->column();

$eventsNumber = $provider->pagination->totalCount;

$workshopDates = [];

//$('.calendar').datepicker("setDate", null);
//$('.calendar').find(".ui-datepicker-current-day").removeClass("ui-datepicker-current-day"); // this actually removes the highlight

//for ($i = 0; $i < $eventsNumber; $i++) {
//
//    $startDate = new DateTime($events[$i]->start);
//
//    if ($events[$i]->end) {
//        $endDate = new DateTime($events[3]->end);
//
//        for ($startDate = new DateTime($events[3]->start); $startDate < $endDate; $startDate->add(new DateInterval('P1D'))) {
//            echo \yii\helpers\VarDumper::dump($startDate);
//        }
//    }
//
//    $workshopDates[] = $startDate;
//
//    echo \yii\helpers\VarDumper::dump($workshopDates);
//
//}
//    if($events[$i]->end){

//for ($startDate = new DateTime($events[3]->start); $startDate !== $events[3]->end; $startDate->add(new DateInterval('P1D'))) {
//
//    $workshopDates[] = $startDate;
//}
//    }
//}

?>

<div class="site-container flex-container">

    <aside class="filter-column workshop-filter-column">

        <div class="filter-column-top">
            <?php
            if ($events) {
                $smallThumbsList = '';

                foreach ($smallThumbs as $smallThumb) {
                    $smallThumbsList .= "<li class='small-thumb'><img src='{$smallThumb}'/></li>";
                }

                if ($eventsNumber != 0 && $eventsNumber < 3 && $smallThumbsNumber < $eventsNumber) {
                    for ($i = 0; $i < $eventsNumber; $i++) {
                        $smallThumbsList .= "<li class='small-thumb'></li>";
                    }
                };
                echo ($smallThumbsList == '') ? null : '<ul class="small-thumbs-list events-thumbs-list">' . $smallThumbsList . '</ul>';
            } ?>
            <span class="number events-number"><?= $eventsNumber . ' event' . (($eventsNumber !== 1) ? 's' : null) ?></span>

        </div>

        <h1 class="filter-title">Filter by</h1>

        <div class="fields-container">
            <?php $form = ActiveForm::begin([
                    'action' => Url::to(['event/index']),
                    'layout' => 'default',
                    'method' => 'GET',
                    'options' => ['class' => 'filter-form']
                ]
            ); ?>

            <!--             $form->field($condition, 'start', [
                            'horizontalCssClasses' => ['wrapper' => false, 'offset' => false],
                        ])
                            ->widget(DatePicker::className(), [
                                'name' => 'dp_5',
                                'inline' => true,
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => [
                                    'defaultDate' => null,
                                    'change' => 'this.form.submit()',
                                    'yearRange' => '2017'],
                                'clientOptions' => [
                                    'defaultDate' => null,
                                    'beforeShowDay' => new yii\web\JsExpression('setScheduledDays'),
                                    'onSelect' => new yii\web\JsExpression('function(){$("#w0").submit();}'),
                                ]
                            ])->label(false) ?> -->

            <!-- $form->field($condition, 'start')->hiddenInput(['value' => null]) ?> -->

            <?= $form->field($condition, 'country_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]],
                ['options' => ['class' => 'sort-select-field']])
                ->dropDownList($countryList, ['prompt' => 'Country', 'onchange' => 'this.form.submit()'])->label(false) ?>

            <?= $form->field($condition, 'type_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]],
                ['options' => ['class' => 'sort-select-field-2']])
                ->dropDownList(EventType::find()->select(['name'])->indexBy('id')->distinct()->column(),
                    ['prompt' => 'Type', 'onchange' => 'this.form.submit()'])->label(false) ?>

            <?= $form->field($condition, 'trainer_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]])
                ->dropDownList($curatorsNameList, [
                    'prompt' => 'Curator',
                    'onchange' => 'this.form.submit()',
                    'placeholder' => 'Curator'])->label(false) ?>

            <?= $form->field($condition, 'tag_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]])
                ->widget(Select2::className(), [
                    'data' => Tag::find()
                        ->select('name')
                        ->indexBy('id')
                        ->column(),
                    'options' => [
                        'placeholder' => 'Topics',
                        'onchange' => 'this.form.submit()',
                        'class' => 'form-control',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'margin' => '0 8px'

                    ],
                ])
                ->label(false); ?>

            <?php ActiveForm::end(); ?>
        </div>

        <?= Html::a('Clear all filters', ['/event/index'], ['class' => 'clear-filter']) ?>

    </aside>

    <section class="events-grid main-grid">
        <?= $eventsNumber == 0 ? '<p class="nothing-found-message">No events found :-(</p>' : '<ul class="events-list">' ?>

        <?php foreach ($events as $event) {
            echo '<li class="item event-item">';

            echo '<section class="event-info">';

            echo '<div class="thumb">' . ($event->thumb ? "<img src='$event->thumb' />" : null) . '</div>';

            echo '<div class="event-content">';

            if ($event->tags) {

                echo "<ul class='event-topics'>";

                $topicsNewList = '';
                foreach ($event->tags as $tag) {
                    $topicsNewList .= '<li class="topic">' . $tag->name . '</li> ';
                }

                echo $topicsNewList . '</ul>';
            }

            echo '<h2 class="name item-name event-name">' . Html::a($event->name, ['/event/view', 'id' => $event->id]) . '</h2>';

            echo '<ul class="event-options">';
            echo($event->address ? '<li class="event-address">' . $event->address . '</li>' : null);
            echo '<li class="event-curator">'
                . Html::a($event->trainer->name . ' ' . $event->trainer->surname, ['/trainer/profile', 'id' => $event->trainer->id]) .
                "</li>" .
                "<li class='event-price'>$$event->price</li>" .
                '</ul>';

            echo "<p class='event-desc'>$event->desc</p></div></section>";

            echo '<section class="event-dates">';

            echo '<span class="date start-date">' .
                '<span class="day">' . Yii::$app->formatter->asDate($event->start, 'php:d') . '</span>' .
                '<span class="month">' . Yii::$app->formatter->asDate($event->start, 'php:M') . '</span>' .
                '</span>';

            echo($event->end ?
                '<span class="dash"></span>' .
                '<span class="date end-date"><span class="day">' . Yii::$app->formatter->asDate($event->end, 'php:d') . '</span>' .
                '<span class="month">' . Yii::$app->formatter->asDate($event->end, 'php:M') . '</span ></span>' : null);


            echo '</section></li>';

        } ?>

        <?= $events ? '</ul>' : null ?>

        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $provider->pagination,
        ]) ?>

    </section>
</div>
