$(document).ready(function(){
    $('#cy').width(viewWidth).height(viewHeight);

    var cy = cytoscape({

        container: document.getElementById('cy'), // container to render in

        elements: {
            nodes: nodes,
            edges: links
        },

        style: [ // the stylesheet for the graph
            {
                selector: 'node',
                style: {
                    'background-color': 'data(color)',
                    'label': 'data(name)',
                    'shape': 'ellipse',
                    //'width': 'content',
                    'text-valign' : 'center',
                    'text-halign' : 'center',
                    'font-size' : 12,
                    "text-outline-color":"#555",
                    "text-outline-width":"2px",
                    "color": "#fff",
                    'border-color': '#555',
                    'border-width': 3,
                    'border-opacity': 0.5
                }

            },

            {
                selector: 'edge',
                style: {
                    'width': 3,
                    'line-color': '#ccc',
                    'target-arrow-color': '#ccc',
                    'target-arrow-shape': 'triangle'
                }
            }
        ],

        layout: {
            name: 'breadthfirst',

            fit: true, // whether to fit the viewport to the graph
            directed: true, // whether the tree is directed downwards (or edges can point in any direction if false)
            padding: 10, // padding on fit
            circle: false, // put depths in concentric circles if true, put depths top down if false
            spacingFactor: 0.35, // positive spacing factor, larger => more space between nodes (N.B. n/a if causes overlap)
            boundingBox: undefined, // constrain layout bounds; { x1, y1, x2, y2 } or { x1, y1, w, h }
            avoidOverlap: true, // prevents node overlap, may overflow boundingBox if not enough space
            //roots: '#6', // the roots of the trees
            maximalAdjustments: 0, // how many times to try to position the nodes in a maximal way (i.e. no backtracking)
            animate: false, // whether to transition the node positions
            animationDuration: 500, // duration of animation in ms if enabled
            animationEasing: undefined, // easing of animation if enabled
            ready: undefined, // callback on layoutready
            stop: undefined // callback on layoutstop
        }

    });

    cy.on('tap', 'node', function(){
        try { // your browser may block popups
            window.open( this.data('href') );
        } catch(e){ // fall back on url change
            window.location.href = this.data('href');
        }
    });

    cy.on('tapdragover', 'node', function(){
        $()
    });

});
