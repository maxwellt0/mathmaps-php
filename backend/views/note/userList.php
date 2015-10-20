<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\PermissionHelpers;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\NoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $usingTabs */

//$this->title = $model->user->username . "'s notes";
$this->title = Yii::$app->user->identity->username . "'s notes";
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    foreach ($usingTabs as $value => $tabName) {
        echo Html::a($tabName, ['user-list', 'status' => $value], ['class' => 'btn btn-primary']) . ' ';
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