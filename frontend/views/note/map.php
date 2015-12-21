<?php

use yii\helpers\Html;
use frontend\widgets\dracula\Graph;

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
        'nodes' => $nodesModel,
        'links' => $linksModel,
    ]) ?>

</div>
<script type="text/javascript">
    var viewWidth = document.getElementById("note-map").clientWidth;
    var viewHeight = document.body.clientHeight*0.5;
</script>