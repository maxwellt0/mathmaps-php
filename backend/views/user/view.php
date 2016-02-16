<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;
/* @var $this yii\web\View */
/* @var $model common\models\user */
$this->title = 'Сторінка користувача ' . $model->username;
$show_this_nav = PermissionHelpers::requireMinimumRole('SuperUser');
$this->params['breadcrumbs'][] = ['label' => 'Користувачі', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <h1><?= $model->username ?></h1>
    <p>
        <?php if (!Yii::$app->user->isGuest && $show_this_nav) {
            echo Html::a('<i class="fa fa-pencil"></i>' . ' Редагувати', ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']);}?>
        <?php if (!Yii::$app->user->isGuest && $show_this_nav) {
            echo Html::a('<i class="fa fa-times"></i>' . ' Видалити', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Ви підтверджуєте видалення?'),
                    'method' => 'post',
                ],
            ]);}?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute'=>'profileLink', 'format'=>'raw'],
            ['attribute'=>'notesLink', 'format'=>'raw'],
            'email:email',
            'roleName',
            'statusName',
// lazyload 'status.status_name',
            'created_at',
            'updated_at',
        ],
    ]) ?>
</div>