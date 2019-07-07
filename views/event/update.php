<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$formTitle = 'Update event';
/** @var string $curatorName */
$this->title = $formTitle . ' | ' . $curatorName;
?>
<div class="event-update">

    <?= Html::errorSummary($model) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'formTitle' => $formTitle
    ]) ?>

</div>