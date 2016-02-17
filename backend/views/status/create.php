<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\status */

$this->title = 'Створити статус';
$this->params['breadcrumbs'][] = ['label' => 'Статуси користувачів', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
