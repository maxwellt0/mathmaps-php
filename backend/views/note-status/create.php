<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NoteStatus */

$this->title = 'Створення статусу запису';
$this->params['breadcrumbs'][] = ['label' => 'Статуси запитів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
