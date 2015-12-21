<?php

use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use frontend\widgets\dracula\Graph;

/* @var $this yii\web\View */
/* @var $noteModel common\models\note */
/* @var $nodesModel */
/* @var $linksModel */
/* @var $userNote */
/* @var boolean $userIsOwner */

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
        if ($userIsOwner) {
            echo Html::a('Редагувати', ['update', 'id' => $noteModel->id], ['class' => 'btn btn-primary']);
        } ?>
        <?php /* Html::a('Delete', ['delete', 'id' => $noteModel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])*/ ?>
        <?= Html::a('Вся карта', ['view-map', 'id' => $noteModel->id], ['class' => 'btn btn-primary']) ?>
        <?php if (!Yii::$app->user->isGuest) {
            if (!$userNote) {
                echo Html::a('Вивчити', ['add-to-list', 'id' => $noteModel->id], ['class' => 'btn btn-primary']);
            } else {
                $buttons = ['btn-default', 'btn-info', 'btn-success', 'btn-warning', 'btn-danger',];
                $droptions = [];
                foreach($userNote->usingStatusList as $stId => $stName){
                    $droptions[] = [
                        'label' => $stName,
                        'url' => [
                            'change-status',
                            'noteId' => $noteModel->id,
                            'statusId'=>$stId]
                    ];
                }
                echo ButtonDropdown::widget([
                    'label' => $userNote->usingStatus->status_name,
                    'dropdown' => [ 'items' =>$droptions ],
                    'options' => [
                        'class' => 'btn status-button ' . $buttons[$userNote->usingStatus->status_value]
                    ]
                ]);
            }
        } ?>
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
