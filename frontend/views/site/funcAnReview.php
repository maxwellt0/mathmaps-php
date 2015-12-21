<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'MathMaps — Функціональний аналіз в діаграмах Ейлера';
?>


<div class="site-func-an-review">

    <div class="row index-img-div">
        <div class="col-md-6">
            <?= Html::img('@web/images/01.jpg', ['class' => 'index-img img-responsive']) ?>
        </div>
        <div class="col-md-6">
            <h2>
                ЛТ — лінійні топологічні простори <br>
                Н — нормовані простори <br>
                Е — евклідові простори <br>
                Б — банахові простори <br>
                Г — гільбертові простори <br>
            </h2>
        </div>
    </div>
    <div class="row index-img-div">
        <div class="col-md-6">
            <?= Html::img('@web/images/02.jpg', ['class' => 'index-img img-responsive']) ?>
        </div>
        <div class="col-md-6">
            <h2>
               Т — топологічні простри <br>
               ТМ — топологічні метризовані простори
            </h2>
        </div>
    </div>

</div>