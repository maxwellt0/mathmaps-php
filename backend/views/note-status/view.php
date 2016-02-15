<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\NoteStatus */

$this->title = $model->status_name;
$this->params['breadcrumbs'][] = ['label' => 'Статуси записів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-status-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fa fa-pencil"></i>' . ' Редагувати', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fa fa-times"></i>' . ' Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Підтверджуєте видалення?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'status_value',
            'status_name'
        ],
    ]) ?>

</div>
