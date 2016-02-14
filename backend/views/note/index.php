<?php

use common\models\NoteType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusTabs */

$this->title = 'Записи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $btnStyles = ['btn-default','btn-success','btn-primary','btn-danger'];
    foreach ($statusTabs as $value => $tabName) {
        /** @var int $tabCounts */
        echo Html::a($tabName . ' <span class="badge">' . $tabCounts[$value] . '</span>', ['index', 'status' => $value], ['class' => 'btn ' . $btnStyles[$value]]) . ' ';
    }
    echo Html::a('<i class="fa fa-plus"></i>' . ' Створити', ['create'], ['class' => 'btn btn-primary pull-right']);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'name',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data->name), Url::to(['view', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'note_type_id',
                'value' => 'noteTypeName',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'note_type_id',
                    ArrayHelper::map(
                        NoteType::find()->asArray()->all(),
                        'id',
                        'type_name'
                    ),
                    ['class'=>'form-control','prompt' => '- Виберіть тип -']
                ),
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete} {accept} {deny}',
                'buttons'=>[
                    'accept' => function ($url, $model) {
                        return Html::a('<i class="fa fa-hand-o-up"></i>', $url, [
                            'title' => 'Опублікувати',
                        ]);
                    },
                    'deny' => function ($url, $model) {
                        return Html::a('<i class="fa fa-hand-paper-o"></i>', $url, [
                            'title' => 'Відхилити публікацію',
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

</div>
