<?php

namespace frontend\widgets\cytoscape;

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
        if ($this->links) {
            return $this->render('graph', [
                'nodes' => $this -> nodes,
                'links' => $this -> links
            ]);
        } else {
            return '<div id="empty-map"><h3>Немає залежностей</h3></div>';
        }
    }

}