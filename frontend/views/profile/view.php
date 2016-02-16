<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/**
 * @var yii\web\View $this
 * @var frontend\models\Profile $model
 */
$this->title = "Профайл " . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Профайл', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?Php
        //this is not necessary but in here as example
        /*if (PermissionHelpers::userMustBeOwner('profile', $model->id)) {
            echo Html::a('Редагувати', ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']);
        } */
        ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'first_name',
            'user.email',
            'birthdate',
            'genderName',
            'createdAt',
            'updatedAt',
        ],
    ]) ?>
</div>