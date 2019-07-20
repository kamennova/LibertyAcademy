<?php

use app\models\Language;
use app\models\Tag;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use \app\models\Trainer;

/* @var $this yii\web\View
 * @var ActiveDataProvider $provider
 * @var app\models\Article $articles
 * @var app\models\Article $article
 * @var app\models\article\ArticleCondition $condition
 */
$this->title = 'Articles | Liberty Academy';

$meta_desc = 'Read articles on liberty horsemanship';

$this->registerMetaTag(['name' => 'keywords', 'content' =>
    'liberty academy, liberty training, liberty training articles, liberty training blog, liberty horse, liberty horsemanship, liberty horse training']);
$this->registerMetaTag(['name' => 'description', 'content' => $meta_desc]);
$this->registerMetaTag(['og:title' => $this->title]);
$this->registerMetaTag(['og:type' => 'website']);
$this->registerMetaTag(['og:description' => $meta_desc]);

$this->registerCssFile('/build/article_index.css');
$this->registerCssFile('/build/list_layout.css');

$model = new \app\models\RegisterTrainer();

$articles = $provider->getModels();

$smallThumbsQuery = $provider->query;
$smallThumbs = $smallThumbsQuery->select('thumb')->andWhere('thumb<>""')->limit(3)->column();
$smallThumbsNumber = count($smallThumbs);

$articlesNumber = $provider->pagination->totalCount;

$tags = Tag::find()->select('name')->indexBy('id')->orderBy('name')->column();

$authorNameList = Trainer::find()
    ->select(["CONCAT(trainer.name, ' ', trainer.surname) AS fullName", 'trainer.id'])
    ->innerJoin('article', 'trainer.id =  article.trainer_id')
    ->distinct()
    ->indexBy('id')
    ->column();

$commentsList = '';
$articleComments = \app\models\Comment::find()->orderBy(['date' => SORT_DESC])->limit(3)->all();

foreach ($articleComments as $comment) {
    $commentedArticle = \app\models\Article::findOne(['id' => $comment->article_id]);
    $commentsList .= '<li>' .
        '<p class="comment-date">' . $comment->date . '</p>' .
        '<p class="comment-content">„' . $comment->content . '“</p>' .
        '- <strong class="comment-author-name">' . $comment->author_name . '</strong> on ' .
        '<span class="article-name">' . Html::a($commentedArticle->title, ['/article/view', 'id' => $commentedArticle->id])
        . '</span>'
        . '</li>';
} ?>

<div class="site-container flex-container">
    <aside class="filter-column" id="filter-column">
        <div class="filter-column-top">

            <?php if ($articles) {
                $smallThumbsList = '';

                foreach ($smallThumbs as $smallThumb) {
                    $smallThumbsList .= "<li class='small-thumb'><img src='{$smallThumb}'/></li>";
                };

                if ($articlesNumber != 0 && $articlesNumber < 3 && $smallThumbsNumber < $articlesNumber) {
                    for ($i = 0; $i < $articlesNumber; $i++) {
                        $smallThumbsList .= "<li class='small-thumb'></li>";
                    }
                };
                echo ($smallThumbsList == '') ? null : '<ul class="small-thumbs-list articles-thumbs-list">' . $smallThumbsList . '</ul>';
            } ?>
            <span class="number articles-number"><?= $articlesNumber . ' article' . ($articlesNumber !== 1 ? 's' : null) ?></span>

        </div>

        <h1 class="visually-hidden">Liberty training articles</h1>
        <h2 class="filter-title">Filter by</h2>

        <?php $form = ActiveForm::begin([
                'action' => Url::to(['article/index']),
                'layout' => 'default',
                'method' => 'GET',
                'options' => ['class' => 'filter-form'],
            ]
        ); ?>

        <div class="fields-container">
            <?= $form->field($condition, 'title', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]],
                ['options' => ['class' => 'sort-select-field title-field']])
                ->textInput(['placeholder' => 'Title', 'onchange' => 'this.form.submit()'])
                ->label(false); ?>

            <?= $form->field($condition, 'trainer_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]])
                ->dropDownList($authorNameList, ['prompt' => 'Author', 'onchange' => 'this.form.submit()'])
                ->label(false); ?>

            <?= $form->field($condition, 'lang_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]])
                ->dropDownList(Language::find()
                    ->select('language.lang_name, language.id')
                    ->innerJoin('article', 'language.id =  article.lang_id')
                    ->distinct()
                    ->indexBy('id')
                    ->column(), ['prompt' => 'Language', 'onchange' => 'this.form.submit()'])
                ->label(false) ?>

            <?= $form->field($condition, 'tag_id', ['options' => ['class' => 'form-group filter-checkbox-list tag-filter']])
                ->checkboxList($tags, [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $checkedLabel = ($checked ? 'checked' : '');
                        $inputId = str_replace(['[', ']'], ['', ''], $name) . '_' . $index;
                        return "<div class='checkbox'><input type='checkbox' onchange='this.form.submit()' name=$name value=$value id=$inputId {$checkedLabel}>"
                            . "<label class='control-label' for=$inputId>$label</label></div>";
                    },
                ])->label('Tags'); ?>

            <?php ActiveForm::end(); ?>
        </div>

        <?= Html::a('Clear all filters', ['/article/index'], ['class' => 'clear-filter']) ?>

    </aside>

    <section class="articles-grid main-grid" id="main-grid">

        <section class="main-grid-content">
            <?= (count($articles) == 0) ? '<p class="nothing-found-message">No articles found :-(</p>' : null ?>

            <ul class="articles-list">

                <?php foreach ($articles as $article) {

                    echo "<li class='item article-item'>";
                    if ($article->thumb) {
                        echo "<img src='$article->thumb' alt='$article->title' class='article-img'/>";
                    } else {
                        echo "<img src='/img/default.jpg' alt='$article->title' class='article-img'/>";
                    }
                    echo '<div class="tags-container">';

                    foreach ($article->tags as $tag) {
                        echo '<span class="tag">' . Html::a($tag->name, ['article/index', 'ArticleCondition[tag_id]' => $tag->id]) . '</span>';
                    }

                    echo '</div><div class="article-entry"><h2 class="article-name name item-name" >' . Html::a($article->title, ['/article/view', 'id' => $article->id], ['class' => '']) . '</h2>';

                    echo '<span class="article-info"><span class="article-date">' . Yii::$app->formatter->asDate($article->date, 'php:d M Y') .
                        '</span> | <span class="author">by '
                        . Html::a($article->trainer->name . ' ' . $article->trainer->surname, ['/trainer/profile', 'id' => $article->trainer->id]) .
                        '</span></span></div></li>';
                } ?>

            </ul>
        </section>

        <section class="articles-side-column">
            <section class="recent-comments">
                <h2 class="column-section-title">Recent comments</h2>
                <ul class="comments-list">
                    <?= $commentsList ?>
                </ul>
            </section>
        </section>

        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $provider->pagination
        ]) ?>

    </section>
</div>