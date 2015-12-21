var redraw, g, renderer;
/* only do all this when document has finished loading (needed for RaphaelJS) */
window.onload = function() {

    var width = viewWidth;
    var height = viewHeight;

    g = new Graph();

    var render = function(r, n) {
        var color = Raphael.getColor();

        var textbit = r.text(n.point[0], n.point[1] + 30, n.label).attr({ "font-size": "10px" });       // + 30 nothing, font changes padding
        var width = $(textbit.node).width()*0.9 ;             //changes node width using text width
        textbit.remove();                           //removes the text
        var set = r.set().push(
            r.ellipse(n.point[0], n.point[1], width, 20).attr({
                "fill": color,
                stroke: color,
                "stroke-width": 2
        })).push(r.text(n.point[0], n.point[1], n.label).attr({"font-size": "14px"})
        );
        /* custom tooltip attached to the set */
        /*set.items.forEach(
            function(el) {
                el.tooltip(r.set().push(r.rect(0, 0, 0, 0).attr({
                    "fill": color,
                    "stroke-width": 1,
                    r: "9px"
                })))
            });*/
        return set;
    };

    g.addNode(nodes[0][0], { label : nodes[0][1], render : render});
    for (var i=1; i<nodes.length; i++) {
        g.addNode(nodes[i][0], { label : nodes[i][1], render : render});
    }

    for (i=0; i<links.length; i++) {
        g.addEdge(links[i][0], links[i][1], { directed : true });
    }

    /* layout the graph using the Spring layout implementation */
    var layouter = new Graph.Layout.Spring(g);

    /* draw the graph using the RaphaelJS draw implementation */
    renderer = new Graph.Renderer.Raphael('canvas', g, width, height);

    redraw = function() {
        layouter.layout();
        renderer.draw();
    };

    var ellipses = document.getElementsByTagName("ellipse");
    for (i=0; i<ellipses.length; i++){
        ellipses[i].addEventListener('dblclick',redirect,false);
    }

    function redirect(){
        window.location.href = '/index.php?r=note/view&id=' + this.id;
    }

};



