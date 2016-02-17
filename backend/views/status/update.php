<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\status */

$this->title = 'Редагувати статус: ' . ' ' . $model->status_name;
$this->params['breadcrumbs'][] = ['label' => 'Статуси', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->status_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редагувати';
?>
<div class="status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
