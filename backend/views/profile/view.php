<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;
/**
 * @var yii\web\View $this
 * @var frontend\models\Profile $model
 */
$this->title = $model->user->username;
$show_this_nav = PermissionHelpers::requireMinimumRole('SuperUser');
$this->params['breadcrumbs'][] = ['label' => 'Профайли', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">
    <h1>Профайл <?= Html::encode($this->title) ?></h1>
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
            ['attribute'=>'userLink', 'format'=>'raw'],
            'first_name',
            'birthdate',
            'genderName',
            'created_at',
            'updated_at',
        ],
    ])?>
</div>
