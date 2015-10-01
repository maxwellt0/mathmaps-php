<?php
/**
 * Created by PhpStorm.
 * User: Maxwellt
 * Date: 01.10.2015
 * Time: 11:20
 */

namespace frontend\widgets\dpl;

use yii\web\AssetBundle;

class PickListAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/dpl/assets';

    public $autoGenerate = true;

    public $js = [
        'js/buttons.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset'
    ];
}