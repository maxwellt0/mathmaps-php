<?php

use \yii\bootstrap\Modal;
use kartik\social\FacebookPlugin;
use \yii\bootstrap\Collapse;
use \yii\bootstrap\Alert;
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'MathMaps';
?>

<div class="site-index">

    <div class="row index-img-div">
        <div class="col-md-6">
            <?= Html::a(
                    Html::img('@web/images/1dosl.png', ['class' => 'index-img img-responsive']),
                ['/site/func-an-review']
            ) ?>
        </div>
        <div class="col-md-6">
            <?= Html::a(
                Html::img('@web/images/2znah.png', ['class' => 'index-img img-responsive']),
                ['/note/index']
            ) ?>
        </div>
        <div class="col-md-6">
            <?= Html::a(
                Html::img('@web/images/3ruh.png', ['class' => 'index-img img-responsive']),
                ['/note/view-map', 'id'=>'14']
            ) ?>
        </div>
        <div class="col-md-6">
            <?= Html::a(
                Html::img('@web/images/4vivch.png', ['class' => 'index-img img-responsive']),
                ['/note/view', 'id'=>'14']
            ) ?>
        </div>
    </div>
</div>



