<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\NoteType */

$this->title = 'Редагувати тип запису: ' . ' ' . $model->type_name;
$this->params['breadcrumbs'][] = ['label' => 'Типи записів', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->type_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редагувати';
?>
<div class="note-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
