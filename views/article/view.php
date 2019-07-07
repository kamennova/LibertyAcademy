<?php

/** @var /app/models/Article $article */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var \app\models\Trainer $author */
/** @var \app\models\Article $article */
$author = $article->trainer;

$this->title = $article->title . ' | Liberty Academy';
$this->registerCssFile('/css/article_profile.css');
$this->registerCssFile('/css/sort-by-form.css');

$this->registerJs('$(".article-content p:has(img)").addClass("image-p")');

$authorServiceList = '<ul class="services-list">';
if ($author->services) {
    foreach ($author->services as $service) {
        $authorServiceList .= "<li class='trainer-service'>" . $service->service_name . '</li>';
    }
}
$authorServiceList .= '</ul>'; ?>

<div class="site-container">

    <div class="article-container">
        <header class="article-header">
            <div class="article-tags">
                <?php foreach ($article->tags as $tag) {
                    echo '<span class="article-tag">' .
                        Html::a($tag->name, ['article/index', 'ArticleCondition[tag_id]' => $tag->id]) . '</span>';
                } ?>
            </div>
            <h1 class="page-title article-title"><?= Html::encode($article->title) ?></h1>
            <div class="article-meta">
                <div class="article-author">
                    <?= empty($author->thumb) ? null :
                        "<div class='small-thumb'  style='background:url({$author->thumb}) no-repeat center center; background-size: cover'></div>" ?>
                    <span class="author-name">
                        <?= Html::a($author->fullName, ['/trainer/profile', "id" => $article->trainer->id]) ?>
                    </span>
                </div>
                | <span class="article-date">
                    <?= Yii::$app->formatter->asDate($article->date, 'php:d M Y') ?>
                </span>
            </div>
        </header>
    </div>

    <section class="article-content">
        <?= $article->content ?>
    </section>

    <div class="article-container">
        <section class="about-author">

            <h3 class="section-subtitle">About author</h3>
            <div class='author-info-container'>
                <div class='author-thumb'>
                    <?= $author->thumb ? "<img src='{$author->thumb}' class='author-thumb-img' />" : null ?>
                </div>
                <h3 class="author-name">
                    <?= Html::a($author->name . ' ' . $author->surname, ['/trainer/profile', 'id' => $author->id]) ?>
                </h3>
                <p>  <?= $author->articleDesc ?> </p>
                <?= Html::a("All articles by $author->name",
                    ['/article/index', 'ArticleCondition[trainer_id]' => $author->id], ['class' => 'all-articles']) ?>
            </div>

        </section>

        <?php if ($article->comments) {
        $comments_number = count($article->comments); ?>

        <section class="comments">
            <h3 class="comments-section-title"> <?= $comments_number ?>
                comment <?= ($comments_number > 1) ? 's' : null ?>
            </h3>

            <ul class="comments-list">
                <?php foreach ($article->comments as $comment) { ?>
                    <li class="comment-item">
                        <h3 class="comment-author-name name"> <?= $comment->author_name ?></h3>
                        <div class="comment-author-thumbnail"></div>
                        <p class="comment-meta"> <?= $comment->date ?> </p>
                        <p class="comment-content"> <?= $comment->content ?></p>
                        <?= $comment->author_website ? Html::a($comment->author_website, $comment->author_website) .
                            '<br>' : null ?>
                        <span class="comment-reply">Reply</span>
                    </li>
                <?php }

                echo '</ul></section>';
                } ?>

                <section class="leave-comment">
                    <h3 class="comments-section-title">Leave a comment</h3>
                    <?php $form = ActiveForm::begin(['id' => 'comment-form', 'layout' => 'horizontal', 'fieldConfig' => [
                        'enableLabel' => false,
                        'template' => "{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-sm-12',
                            'error' => '',
                            'hint' => '',
                        ],
                    ], 'enableClientValidation' => false,]); ?>

                    <div class="row">
                        <div class="col-sm-6 left-field">
                            <?= $form->field($model, 'author_name')
                                ->textInput(['class' => 'form-control conform11', 'placeholder' => 'Name']) ?>
                        </div>
                        <div class="col-sm-6 right-field">
                            <?= $form->field($model, 'author_email')
                                ->textInput(['type' => 'email', 'class' => 'form-control conform11', 'placeholder' => 'Email']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= $form->field($model, 'author_website')
                                ->textInput(['class' => 'form-control conform11', 'placeholder' => 'Website']) ?>
                        </div>

                        <div class="col-sm-12">
                            <?= $form->field($model, 'content')->textArea(['rows' => 8, 'placeholder' => 'Content']) ?>
                        </div>
                        <div class="form-group" align="center">
                            <?= Html::submitButton('Post comment', ['class' => 'btn', 'name' => 'Post comment']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </section>
    </div>
</div>