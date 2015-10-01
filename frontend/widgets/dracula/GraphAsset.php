<?php
/**
 * Created by PhpStorm.
 * User: Maxwellt
 * Date: 29.09.2015
 * Time: 6:18
 */

namespace frontend\widgets\dracula;

use yii\web\AssetBundle;

class GraphAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/dracula/assets';

    public $autoGenerate = true;

    public $js = [
        'js/raphael-min.js',
        'js/dracula_graph.js',
        'js/dracula_graffle.js',
        'js/graph.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
//        'yii\web\JqueryAsset'
    ];
}