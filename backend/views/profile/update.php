<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

$this->title = 'Редагувати профайл: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Профайли', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редагувати';
?>
<div class="profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
