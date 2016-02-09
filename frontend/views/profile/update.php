<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */

$this->title = 'Налаштування профайлу '. $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Профайл', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Налаштування';
?>
<div class="profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
