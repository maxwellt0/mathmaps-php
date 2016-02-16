<?php
use backend\models\Role;
use backend\models\Status;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use \yii\bootstrap\Collapse;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Користувачі';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo Collapse::widget([
        'items' => [
            [
                'label' => 'Пошук',
                'content' => $this->render('_search', ['model' => $searchModel]),
            ],
        ]
    ]);
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'options' => ['width' => '100'],
            ],
            'email:email',
            [
                'attribute' => 'role_value',
                'value' => 'roleName',
                'options' => ['width' => '130'],
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'role_id',
                    ArrayHelper::map(
                        Role::find()->asArray()->all(),
                        'role_value',
                        'role_name'
                    ),
                    ['class'=>'form-control','prompt' => '- Виберіть -']
                ),
            ],
            [
                'attribute' => 'status_value',
                'value' => 'statusName',
                'options' => ['width' => '130'],
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status_id',
                    ArrayHelper::map(
                        Status::find()->asArray()->all(),
                        'status_value',
                        'status_name'
                    ),
                    ['class'=>'form-control','prompt' => '- Виберіть -']
                ),
            ],
            [
                'attribute'=>'username',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data->username), Url::to(['view', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'options' => ['width' => '100'],
                'filter'=>false,
            ],
            [
                'attribute' => 'updated_at',
                'options' => ['width' => '100'],
                'filter'=>false,
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{profile} {notes} {update} {delete}',
                'options' => ['width' => '90'],
                'buttons'=>[
                    'profile' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-user"></i>',
                            Url::to(['profile/view', 'id' => $model->profileId]),
                            ['title' => 'Профайл',]
                        );
                    },
                    'notes' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-th-list"></i>',
                            Url::to(['note/user-list', 'userId' => $model->id, 'status' => 1]),
                            ['title' => 'Записи',]
                        );
                    }
                ]
            ],
        ],
    ]); ?>
</div>