<?php
/* @var $nodes */
/* @var $links */
?>
<div id="canvas"></div>
<!--<button id="redraw" onclick="redraw();">redraw</button>-->
<script>
    <?php
        $js_nodes = json_encode($nodes);
        $js_links = json_encode($links);
        echo "var nodes = ". $js_nodes . ";\n";
        echo "var links = ". $js_links . ";\n";
    ?>
</script>
