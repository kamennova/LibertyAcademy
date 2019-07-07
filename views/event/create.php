<?php

/* @var $this yii\web\View */
/* @var $model app\models\Trainer */

$formTitle = 'Add event';
/** @var mixed $curatorName */
$this->title = $formTitle . ' | ' . $curatorName;

?>

<div class="event-create">
    <?= $this->render('_form', [
        'model' => $model,
        'formTitle' => $formTitle,
    ]) ?>
</div>