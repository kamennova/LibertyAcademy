<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\article\ArticleForm */

$this->title = 'Update Article: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>

<div class="trainer-update">

    <?= Html::errorSummary($model) ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>