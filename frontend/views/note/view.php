<?php

use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use frontend\widgets\cytoscape\Graph;

/* @var $this yii\web\View */
/* @var $noteModel common\models\note */
/* @var $notesData */
/* @var $linksData */
/* @var $userNote */
/* @var boolean $userIsOwner */

$this->title = $noteModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Записи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-view" id="note-view">

    <?= Graph::widget([
            'nodes' => $notesData,
            'links' => $linksData,
    ]); ?>

    <div class="note-view-buttons">
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

        <?php
        if ($userIsOwner) {
            echo Html::a('<i class="fa fa-pencil"></i>' . ' Редагувати', ['update', 'id' => $noteModel->id], ['class' => 'btn btn-primary']) . " ";
            echo Html::a('<i class="fa fa-times"></i>' . ' Видалити', ['delete', 'id' => $noteModel->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Ви підтверджуєте видалення?',
                    'method' => 'post',
                ],
            ]) . " ";

            /** @var int $publStatus */
            if ($publStatus == 0) {
                $btnStyle = "btn-primary";
                $btnDisabled = false;
            } elseif ($publStatus == 2) {
                $btnStyle = "btn-succes disabled";
                $btnDisabled = true;
            }
            echo Html::a('<i class="fa fa-hand-o-up"></i>' . ' Опублікувати', ['offer', 'id' => $noteModel->id], ['class' => 'btn ' . $btnStyle, 'disabled' => $btnDisabled]);
        } ?>

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
