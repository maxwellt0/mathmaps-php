<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\role */

$this->title = 'Створити роль';
$this->params['breadcrumbs'][] = ['label' => 'Ролі', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
