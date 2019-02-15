<?php

use yii\helpers\Html;

$photosContent = '';

if ($trainer->thumb || $thumbs) {
    if ($thumbs) {
        $photosContent = implode($thumbs);
    }
    if ($trainer->thumb) {
        $photosContent .= "<img src='$trainer->thumb'/><br>";
    }
} else {
    $photosContent = null;
}

?>

<style>
    .aligned-left {
        text-align: left;
    }

    .album-meta {
        display: flex;
        align-items: center;
        margin: 15px 0;
    }

    .small-thumb {
        display: inline-block;
        width: 30px;
        height: 30px;
        margin-right: 11px;

        border-radius: 50%;
    }

    .album-owner {
        display: flex;
    }

    .album-owner .owner-name a {
        margin-right: 10px;

        font-family: Lato, Arial, sans-serif;
        font-size: 15px;
        line-height: 25px;
        font-weight: 500;
        color: rgba(0, 0, 0, 0.8);
        letter-spacing: 1px;
        text-decoration: none;
    }

    .album-owner a:hover, .article-author a:active, .article-author a:visited {
        color: rgba(0, 0, 0, 0.6);
        text-decoration: underline;
    }

    .photos-number {
        margin-left: 10px;
    }

    .gallery-header {
        margin-bottom: 40px;
    }

    .gallery-content{
        display: flex;
        flex-wrap: wrap;
    }

    .gallery-content img{
        display: inline-block;
        width: 250px;
        height: 250px;
        margin-right: 40px;
        margin-bottom: 40px;

        border-radius: 8px;
    }
</style>


<div class="site-container">
    <header class="gallery-header">
        <h1 class="page-title aligned-left">Gallery</h1>
        <div class="album-meta">
            <div class="album-owner">
                <?= empty($trainer->thumb) ? null : "<div class='small-thumb'  style='background:url({$trainer->thumb}) no-repeat center center; background-size: cover'></div>" ?>
                <span class="owner-name"><?= Html::a($trainer->name, ['#', "id" => $trainer->id]) ?></span>
            </div>
            | <span class="photos-number"> 18 photos </span></div>
    </header>

    <section class="gallery-content">

        <?= $photosContent ?>

    </section>

</div>

