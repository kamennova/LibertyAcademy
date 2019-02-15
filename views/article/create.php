<?php

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Add article';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="event-create">

    <?= $this->render('_form', [
        'model' => $model,
//        'title' => $title
    ]) ?>

</div>
