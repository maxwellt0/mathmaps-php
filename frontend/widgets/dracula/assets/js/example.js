var redraw, g, renderer;

/* only do all this when document has finished loading (needed for RaphaelJS) */
window.onload = function() {

    var width = $(document).width() - 200;
    var height = $(document).height() - 400;

    g = new Graph();

    for (var i=0; i<nodes.length; i++) {
        g.addNode(nodes[i]);
    }

    for (i=0; i<links.length; i++) {
        g.addEdge(links[i][1], links[i][2], { directed : true });
    }

    /* layout the graph using the Spring layout implementation */
    var layouter = new Graph.Layout.Spring(g);
    
    /* draw the graph using the RaphaelJS draw implementation */
    renderer = new Graph.Renderer.Raphael('canvas', g, width, height);
    
    redraw = function() {
        layouter.layout();
        renderer.draw();
    };

};



