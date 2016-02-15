<?php
use common\models\NoteType;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $usingTabs */
/* @var $tabCounts */

$this->title = "Записи " . Yii::$app->user->identity->username;
$this->params['breadcrumbs'][] = ['label' => 'Профайл', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php
    $btnStyles = ['btn-default', 'btn-info', 'btn-success', 'btn-warning', 'btn-danger',];
    foreach ($usingTabs as $value => $tabName) {
        echo Html::a(
                $tabName . ' <span class="badge">' . $tabCounts[$value] . '</span>',
                ['user-list', 'status' => $value],
                ['class' => 'btn ' . $btnStyles[$value]]
            ) . ' ';
    }
    echo Html::a(
        '<i class="fa fa-plus"></i>' . ' Створити',
        ['create'],
        ['class' => 'btn btn-primary pull-right']
    ); ?>
    </p>
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