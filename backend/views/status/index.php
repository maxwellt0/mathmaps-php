<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\StatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статуси користувача';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-index">

    <h1><?= Html::encode($this->title) ?>
        <?= Html::a(
            '<i class="fa fa-plus"></i>' . ' Створити',
            ['create'],
            ['class' => 'btn btn-primary pull-right']
        );
        ?>
    </h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute'=>'status_name',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data->status_name), Url::to(['view', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
            'status_value',
            ['class' => 'yii\grid\ActionColumn', 'template'=>'{update} {delete}']
        ],
    ]); ?>

</div>
