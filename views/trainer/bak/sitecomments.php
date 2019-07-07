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

$this->registerCssFile('/css/trainer_view.css');
$this->registerCssFile('/css/list_layout.css');

$this->title = "My articles | " . $model->name . " " . $model->surname;

$articles = $articleDataProvider->getModels();
$articlesNumber = count($articles);

?>

<div class="site-container flex-container">

    <aside class="filter-column">
        <div class="filter-column-top">
            <?php
            if ($thumbsPick) {
                echo '<ul class="small-thumbs-list">';

                foreach ($thumbsPick as $thumb) {
                    echo "<li class='small-thumb'><img src='$thumb' /></li>";
                }

                echo '</ul>';
            }
            ?>
            <span class="number"><?= $commentsNumber ?> comments</span>
        </div>

        <h1 class="filter-title">Moderate comments</h1>
        <div class="fields-container">
            <?= $this->render('myarticles_search', ['model' => $articleSearchModel]) ?>
        </div>
        <?= Html::a('Clear all filters', ['/trainer/myarticles'], ['class' => 'clear-filter']) ?>
    </aside>

    <section class="my-articles-grid main-grid">
        <?= Html::a('Add article', ['article/create', 'trainer_id' => $model->id], ['class' => 'btn btn-smaller btn-add btn-add-article']); ?>
<!--        <div class="my-articles">-->

            <?= GridView::widget([
                'dataProvider' => $articleDataProvider,
                'layout' => "{summary}\n{items}\n{pager}",
                'summary' => "<div class='summary'>Site comments: showing <b>{begin} - {end}</b> of <b>{count}</b> items</div>",
                'emptyText' => 'No articles found :-(',
                'tableOptions' => [
                    'class' => 'table-view'
                ],
                'rowOptions' => [
                    'class' => 'table-view-row'
                ],
                'columns' => [
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
                        'attribute' => 'title',
                        'value' => function ($article) {
                            return "<div class='article-thumb'>" . ($article->thumb ? "<img src='$article->thumb' />" : null) . "</div>" .
                                Html::a("$article->title", ['/article/view', 'id' => $article->id], ['class' => 'article-title']);
                        },
                        'format' => 'raw',
                        'contentOptions' => ['class' => 'title-td'],
                        'headerOptions' => ['class' => 'title-th']
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'controller' => 'article',
                        'header' => 'Actions',
                        'headerOptions' => ['style' => 'width: 90px;  text-align: center'],
                        'contentOptions' => ['style' => ' text-align: center']
                    ],
                ],
            ]); ?>
<!--        </div>-->
    </section>

</div>