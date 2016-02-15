<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NoteStatus */

$this->title = 'Редагування статусу запису: ' . ' ' . $model->status_name;
$this->params['breadcrumbs'][] = ['label' => 'Статуси записів', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->status_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редагувати';
?>
<div class="note-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
