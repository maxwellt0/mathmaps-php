<?php
/**
 * Created by PhpStorm.
 * User: Maxwellt
 * Date: 29.09.2015
 * Time: 4:25
 */

namespace frontend\widgets\dracula;

use Yii;
use yii\base\Widget;


class Graph extends Widget
{
    public $nodes;
    public $links;

    public function init()
    {
        parent::init();
//        ob_start();
        GraphAsset::register($this->getView());
    }

    public function run()
    {
//        $content = ob_get_clean();
        return $this->render('graph', [
            'nodes' => $this -> nodes,
            'links' => $this -> links
        ]);
    }

}