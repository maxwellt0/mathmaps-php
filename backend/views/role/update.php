<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\role */

$this->title = 'Редагувати роль: ' . ' ' . $model->role_name;
$this->params['breadcrumbs'][] = ['label' => 'Ролі', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->role_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редагувати';
?>
<div class="role-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
