<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\NoteType */

$this->title = 'Створити тип запису';
$this->params['breadcrumbs'][] = ['label' => 'Типи записів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
