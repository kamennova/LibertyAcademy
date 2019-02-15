<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Trainer */

$formTitle = 'Add workshop';
$this->title = $formTitle . ' | ' . $curatorName;
//$this->params['breadcrumbs'][] = ['label' => 'Workshops', 'url' => ['create']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="event-create">
    <?= $this->render('_form', [
        'model' => $model,
        'formTitle' => $formTitle
    ]) ?>
</div>
