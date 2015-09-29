<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\widgets\dracula\Graph;

/* @var $this yii\web\View */
/* @var $noteModel common\models\note */
/* @var $nodesModel */
/* @var $linksModel */

$this->title = $noteModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="note-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Graph::widget([
        'nodes' => $nodesModel,
        'links' => $linksModel,
    ]) ?>

    <p>
        <?= Html::a('Update', ['update', 'id' => $noteModel->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $noteModel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $noteModel,
        'attributes' => [
            'name',
            'noteTypeName',
            'text:html',
        ],
    ]) ?>

</div>
<script type="text/x-mathjax-config">
    MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
</script>
<script type="text/javascript"
        src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
