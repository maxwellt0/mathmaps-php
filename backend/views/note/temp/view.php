<?php

use common\models\ValueHelpers;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use frontend\widgets\dracula\Graph;

/* @var $this yii\web\View */
/* @var $noteModel common\models\note */
/* @var $nodesModel */
/* @var $linksModel */

$this->title = $noteModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Записи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-view" id="note-view">

    <?= Graph::widget([
            'nodes' => $nodesModel,
            'links' => $linksModel,
    ]); ?>

    <div class="note-view-buttons">
        <?php
        $is_admin = ValueHelpers::getRoleValue('Admin');
        if (!Yii::$app->user->isGuest
            && Yii::$app->user->identity->role_id >= $is_admin) {
            echo Html::a('<i class="fa fa-pencil"></i>' . ' Редагувати', ['update', 'id' => $noteModel->id], ['class' => 'btn btn-primary']) . " ";
            echo Html::a('<i class="fa fa-times"></i>' . ' Видалити', ['delete', 'id' => $noteModel->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Ви підтверджуєте видалення?',
                    'method' => 'post',
                ],
            ]);
        }
        ?>

        <?= Html::a('<i class="fa fa-expand"></i>' . ' Вся карта', ['view-map', 'id' => $noteModel->id], ['class' => 'btn btn-primary pull-right']) ?>
    </div>

    <?= DetailView::widget([
        'model' => $noteModel,
        'attributes' => [
            'name',
            'noteTypeName',
            'text:ntext',
        ],
    ]) ?>

</div>
<script type="text/javascript">
    var viewWidth = document.getElementById("note-view").clientWidth;
    var viewHeight = document.body.clientHeight*0.3;
</script>
<script type="text/x-mathjax-config">
    MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
</script>
<script type="text/javascript"
        src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
