<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusTabs */

$this->title = 'Notes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    foreach ($statusTabs as $value => $tabName) {
        echo Html::a($tabName, ['index', 'status' => $value], ['class' => 'btn btn-primary']) . ' ';
    }
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'noteTypeName',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
