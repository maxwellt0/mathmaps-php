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

    <div class="row">
        <div class="col-md-8">
            <h1>Дивись на речі широко</h1>
            <?=file_get_contents('http://loripsum.net/api/3/short/'); ?>
        </div>
        <div class="col-md-4">
            <?php //Html::img('@web/images/3ruh.png', ['class' => 'index-img img-responsive']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 pull-right">
            <h1>Тримай навчання під контролем</h1>
            <?=file_get_contents('http://loripsum.net/api/3/short/'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h1>Прискорюйся</h1>
            <?=file_get_contents('http://loripsum.net/api/3/short/'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 pull-right">
            <h1>Відкривай нові території</h1>
            <?=file_get_contents('http://loripsum.net/api/3/short/'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h1>Вивантажуй</h1>
            <?=file_get_contents('http://loripsum.net/api/3/short/'); ?>
        </div>
    </div>
</div>



