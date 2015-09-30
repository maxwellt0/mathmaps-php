<?php

use yii\helpers\Html;
use frontend\widgets\dracula\Graph;

/* @var $this yii\web\View */
/* @var $noteModel common\models\note */
/* @var $nodesModel */
/* @var $linksModel */

$this->title = $noteModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $noteModel->name, 'url' => ['view', 'id' => $noteModel -> id]];
$this->params['breadcrumbs'][] = 'Карта';
?>
<div class="note-map">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Graph::widget([
        'nodes' => $nodesModel,
        'links' => $linksModel,
    ]) ?>

</div>
