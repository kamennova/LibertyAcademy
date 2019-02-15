<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

//$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['update']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';

$formTitle = 'Update workshop';
$this->title = $formTitle . ' | ' . $curatorName;
?>
<div class="event-update">
    <?= Html::errorSummary($model) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'formTitle' => $formTitle
    ]) ?>


</div>
