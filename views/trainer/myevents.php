<?php

use app\models\Tag;
use kartik\select2\Select2;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->registerCssFile('/css/trainer_view.css');
$this->registerCssFile('/css/list_layout.css');

$this->title = "My events | " . $model->name . " " . $model->surname;

/** @var mixed $eventDataProvider */
$events = $eventDataProvider->getModels();
$eventsNumber = count($eventDataProvider->getModels());

?>

<div class="site-container flex-container">

    <aside class="filter-column">

        <div class="filter-column-top">
            <?php
            /** @var mixed $thumbsPick */
            if ($thumbsPick) {
                echo '<ul class="small-thumbs-list">';

                foreach ($thumbsPick as $thumb) {
                    echo "<li class='small-thumb'><img src='$thumb' /></li>";
                }

                echo '</ul>';
            }
            ?>
            <span class="number"><?= $eventsNumber ?> events</span>
        </div>

        <h1 class="filter-title">Filter events</h1>

        <div class="fields-container">
            <?= $this->render('myevents_search', ['model' => $eventSearchModel]) ?>
        </div>

        <?= Html::a('Clear all filters', ['/trainer/myevents'], ['class' => 'clear-filter']) ?>
    </aside>

    <section class="my-events-grid main-grid">

        <?= Html::a('Add event', ['event/create', 'trainer_id' => $model->id],
            ['class' => 'btn btn-smaller btn-add btn-add-event']); ?>

        <?= GridView::widget([
            'dataProvider' => $eventDataProvider,
            'layout' => "{summary}\n{items}\n{pager}",
            'summary' => "<div class='summary'>My events: showing <b>{begin} - {end}</b> of <b>{count}</b> items</div>",
            'emptyText' => 'No events found :-(',
            'tableOptions' => [
                'class' => 'table-view'
            ],
            'rowOptions' => [
                'class' => 'table-view-row'
            ],
            'columns' => [
                [
                    'attribute' => 'name',
                    'value' => function ($event) {

                        return "<div class='article-thumb'>" . ($event->thumb ? "<img src='$event->thumb' />" : null) . "</div>" .
                            Html::a("$event->name", ['/event/view', 'id' => $event->id], ['class' => 'article-title']);
                    },
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'title-td'],
                    'headerOptions' => ['class' => 'title-th']
                ],
                [
                    'value' => function ($article) {
                        $tags = '';
                        foreach ($article->tags as $tag) {
                            $tags .= "<span class='article-tag'>" . $tag->name . '</span>';
                        }
                        return substr($tags, 0, -2);
                    },
                    'format' => 'raw',
                    'header' => 'Topics',
                    'filter' => Select2::widget([
                        'data' => Tag::find()->select('name')->indexBy('id')->column(),
                        'name' => 'tags',
                        'options' => [
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                    'contentOptions' => ['class' => 'tags-td'],
                    'headerOptions' => ['class' => 'tags-th']
                ],
                [
                    'attribute' => 'start',
                    'value' => 'start',
                    'filter' => DatePicker::widget([
                        'model' => $eventSearchModel,
                        'attribute' => 'start',
                    ]),
                    'format' => 'date',
                    'contentOptions' => ['class' => 'date-td']
                ],
                [
                    'class' => ActionColumn::class,
                    'controller' => 'event',
                    'header' => 'Actions',
                    'headerOptions' => ['style' => 'width: 90px;  text-align: center'],
                    'contentOptions' => ['style' => ' text-align: center']
                ],
            ],
        ]); ?>

    </section>
</div>