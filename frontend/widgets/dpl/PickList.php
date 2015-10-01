<?php
/**
 * Created by PhpStorm.
 * User: Maxwellt
 * Date: 01.10.2015
 * Time: 7:51
 */

namespace frontend\widgets\dpl;

use yii\base\Widget;

class PickList extends Widget
{
    public $source;
    public $model;

    public function init()
    {
        parent::init();
        PickListAsset::register($this->getView());
    }

    public function run()
    {
        return $this->render('picklist', [
            'source' => $this -> source,
            'model' => $this -> model,
        ]);
    }
}