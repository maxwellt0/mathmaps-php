<?php

use common\models\NoteType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Записи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-index">

    <h1><?= Html::encode($this->title) ?></h1>

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
            ]
        ],
    ]); ?>

</div>
