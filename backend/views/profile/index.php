<?php
use frontend\models\Gender;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Collapse;
use yii\helpers\Url;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Профайли';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'options' => ['width' => '100'],
            ],
            [
                'attribute'=>'first_name',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data->first_name), Url::to(['view', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
            [
                'attribute'=>'username',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data->username), Url::to(['user/view', 'id' => $data->user_id]));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'birthdate',
                'format' => 'html',
                'filter' => DatePicker::widget(
                    [
                        'model' => $searchModel,
                        'attribute' => 'birthdate',
                        'options' => [
                            'class' => 'form-control'
                        ],
                        'clientOptions' => [
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'minDate' => '-110Y',
                            'maxDate' => '+0D',
                            'yearRange' => "-80:+0",
                        ],
                    ]
                )
            ],
            [
                'attribute' => 'gender_id',
                'value' => 'genderName',
                'options' => ['width' => '130'],
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'gender_id',
                    ArrayHelper::map(
                        Gender::find()->asArray()->all(),
                        'id',
                        'gender_name'
                    ),
                    ['class'=>'form-control','prompt' => '- Виберіть -']
                ),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
                'options' => ['width' => '90']
            ],
        ],
    ]); ?>
</div>
