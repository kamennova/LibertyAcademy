<?php
/**
 * @var ActiveDataProvider $articleDataProvider
 * @var ArticleSearch $articleSearchModel
 */

use app\models\article\ArticleSearch;
use app\models\Tag;
use kartik\select2\Select2;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->registerCssFile('/build/filter_layout.css');

$this->title = "My articles | " . $model->name . " " . $model->surname;

$articles = $articleDataProvider->getModels();
$articlesNumber = count($articles);

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
            <span class="number"><?= $articlesNumber ?> article<?= $articlesNumber == 1 ? null : 's' ?></span>
        </div>

        <h1 class="filter-title">Filter articles</h1>
        <div class="fields-container">
            <?= $this->render('myarticles_search', ['model' => $articleSearchModel]) ?>
        </div>
        <?= Html::a('Clear all filters', ['/trainer/myarticles'], ['class' => 'clear-filter']) ?>
    </aside>

    <section class="my-articles-grid main-grid">
        <?= Html::a('Add article', ['article/create', 'trainer_id' => $model->id], ['class' => 'btn btn-smaller btn-add btn-add-article']); ?>

            <?= GridView::widget([
                'dataProvider' => $articleDataProvider,
                'layout' => "{summary}\n{items}\n{pager}",
                'summary' => "<div class='summary'>My articles: showing <b>{begin} - {end}</b> of <b>{count}</b> items</div>",
                'emptyText' => 'No articles found :-(',
                'tableOptions' => [
                    'class' => 'table-view'
                ],
                'rowOptions' => [
                    'class' => 'table-view-row'
                ],
                'columns' => [
                    [
                        'attribute' => 'title',
                        'value' => function ($article) {
                            return "<div class='item-thumb'>" . ($article->thumb ? "<img src='$article->thumb' />" : null) . "</div>" .
                                Html::a("$article->title", ['/article/view', 'id' => $article->id], ['class' => 'item-title']);
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
                        'header' => 'Tags',
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
                        'attribute' => 'date',
                        'value' => 'date',
                        'filter' => DatePicker::widget([
                            'model' => $articleSearchModel,
                            'attribute' => 'date',
                        ]),
                        'format' => 'date',
                        'contentOptions' => ['class' => 'date-td']
                    ],
                    [
                        'class' => ActionColumn::class,
                        'controller' => 'article',
                        'header' => 'Actions',
                        'headerOptions' => ['style' => 'width: 90px;  text-align: center'],
                        'contentOptions' => ['style' => ' text-align: center']
                    ],
                ],
            ]); ?>
    </section>
</div>