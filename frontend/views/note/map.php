<?php

use yii\helpers\Html;
use frontend\widgets\cytoscape\Graph;

/* @var $this yii\web\View */
/* @var $noteModel common\models\note */
/* @var $nodesModel */
/* @var $linksModel */

$this->title = $noteModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Записи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $noteModel->name, 'url' => ['view', 'id' => $noteModel -> id]];
$this->params['breadcrumbs'][] = 'Карта';
?>
<div class="note-map" id="note-map">

    <?= Graph::widget([
        'nodes' => $notesData,
        'links' => $linksData,
    ]) ?>

</div>
<script type="text/javascript">
    var viewWidth = document.getElementById("note-map").clientWidth;
    var viewHeight = document.body.clientHeight*0.8;
</script>