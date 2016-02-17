<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\role */

$this->title = $model->role_name;
$this->params['breadcrumbs'][] = ['label' => 'Ролі', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-view">

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
            'role_value',
            'role_name'
        ],
    ]) ?>

</div>
