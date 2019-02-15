<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Trainer */

$this->title = 'Update Trainer: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Trainers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="trainer-update">
    <?= Html::errorSummary($model) ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
