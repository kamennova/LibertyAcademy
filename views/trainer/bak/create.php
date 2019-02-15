<?php

/* @var $this yii\web\View */
/* @var $model app\models\Trainer */

$this->title = 'Create Trainer';
$this->params['breadcrumbs'][] = ['label' => 'Trainers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="trainer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
