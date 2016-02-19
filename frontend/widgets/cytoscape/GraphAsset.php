<?php

namespace frontend\widgets\cytoscape;

use yii\web\AssetBundle;

class GraphAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/cytoscape/assets';

    public $autoGenerate = true;

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public $js = [
        'js/cytoscape.js',
//        'js/cytoscape.js.map',
        'js/map.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'
    ];
}