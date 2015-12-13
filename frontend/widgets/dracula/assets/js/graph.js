var redraw, g, renderer;
/* only do all this when document has finished loading (needed for RaphaelJS) */
window.onload = function() {

    var width = $(document).width()*0.6;
    var height = $(document).height()*0.6;

    g = new Graph();

    var renderRed = function(r, n) {
        var color = Raphael.getColor();
        //var ellipse = r.ellipse(0, 0, 30, 20)
        //    .attr({fill: color, stroke: color, "stroke-width": 2})
        //    .push(r.text(0, 30, n.label))
        //    .attr({"font-size":"20px"});
        //var set = r.set().push(ellipse);
        var set = r.set().push(
            r.ellipse(n.point[0]-30, n.point[1]-13, 30, 20)
                .attr({fill: "red", stroke: "red", "stroke-width": 2}))
                .push(r.text(n.point[0], n.point[1] + 30, n.label)
                .attr({"font-size":"20px"})
        );

        set.items.forEach(
            function(el) {
                //var color = Raphael.getColor();
                el.tooltip(r.set().push(r.rect(0, 0, 30, 30)
                    .attr({"fill": color, "stroke-width": 1, r : "9px"})))}
        );
        return set;
        /* the default node drawing */
    };

    var render = function(r, n) {
        var textbit = r.text(n.point[0], n.point[1] + 30, n.label).attr({ "font-size": "14px" });
        var width = $(textbit.node).width() + 10 ;
        textbit.remove();
        var set = r.set().push(
        r.rect(n.point[0] - Math.round(width / 2), n.point[1] - 13, width, 86).attr({
            "fill": "#fa8",
            "stroke-width": 2,
            r: "9px"
        })).push(r.text(n.point[0], n.point[1] + 30, n.label).attr({
            "font-size": "14px"
        })); /* custom tooltip attached to the set */
        set.items.forEach(
            function(el) {
                el.tooltip(r.set().push(r.rect(0, 0, 0, 0).attr({
                    "fill": "#fec",
                    "stroke-width": 1,
                    r: "9px"
                })))
            });
        return set;
    };

    var renderGreen = function(r, n) {
        var color = Raphael.getColor();
        var set = r.set().push(
            r.ellipse(n.point[0]-30, n.point[1]-13, 30, 20)
                .attr({fill: "green", stroke: "green", "stroke-width": 2}))
            .push(r.text(n.point[0], n.point[1] + 30, n.label)
                .attr({"font-size":"20px"})
        );

        set.items.forEach(
            function(el) {
                //var color = Raphael.getColor();
                el.tooltip(r.set().push(r.rect(0, 0, 30, 30)
                    .attr({"fill": color, "stroke-width": 1, r : "9px"})))}
        );
        return set;
        /* the default node drawing */
    };

    g.addNode(nodes[0][0], { label : nodes[0][1], render: renderGreen});
    for (var i=1; i<nodes.length; i++) {
        g.addNode(nodes[i][0], { label : nodes[i][1], render: render});
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

    var ellipse = document.getElementsByTagName("ellipse");
    for (i= 0; i<ellipse.length; i++){
        ellipse[i].addEventListener('dblclick',redirect,false);
    }

    function redirect(){
        //alert(this.id);
        window.location.href = '/index.php?r=note/view&id=' + this.id;
    }

};



