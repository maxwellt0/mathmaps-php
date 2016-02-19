$(document).ready(function(){
    $('#cy').width(viewWidth).height(viewHeight);

    //var cy = cytoscape({
    //    container: document.getElementById('cy'),
    //
    //    boxSelectionEnabled: false,
    //    autounselectify: true,
    //
    //    style: cytoscape.stylesheet()
    //        .selector('node')
    //        .css({
    //            'height': 80,
    //            'width': 80,
    //            'background-fit': 'cover',
    //            'border-color': '#000',
    //            'border-width': 3,
    //            'border-opacity': 0.5
    //        })
    //        .selector('.eating')
    //        .css({
    //            'border-color': 'red'
    //        })
    //        .selector('.eater')
    //        .css({
    //            'border-width': 9
    //        })
    //        .selector('edge')
    //        .css({
    //            'width': 6,
    //            'target-arrow-shape': 'triangle',
    //            'line-color': '#ffaaaa',
    //            'target-arrow-color': '#ffaaaa'
    //        })
    //        .selector('#bird')
    //        .css({
    //            'background-image': 'https://farm8.staticflickr.com/7272/7633179468_3e19e45a0c_b.jpg'
    //        })
    //        .selector('#cat')
    //        .css({
    //            'background-image': 'https://farm2.staticflickr.com/1261/1413379559_412a540d29_b.jpg'
    //        })
    //        .selector('#ladybug')
    //        .css({
    //            'background-image': 'https://farm4.staticflickr.com/3063/2751740612_af11fb090b_b.jpg'
    //        })
    //        .selector('#aphid')
    //        .css({
    //            'background-image': 'https://farm9.staticflickr.com/8316/8003798443_32d01257c8_b.jpg'
    //        })
    //        .selector('#rose')
    //        .css({
    //            'background-image': 'https://farm6.staticflickr.com/5109/5817854163_eaccd688f5_b.jpg'
    //        })
    //        .selector('#grasshopper')
    //        .css({
    //            'background-image': 'https://farm7.staticflickr.com/6098/6224655456_f4c3c98589_b.jpg'
    //        })
    //        .selector('#plant')
    //        .css({
    //            'background-image': 'https://farm1.staticflickr.com/231/524893064_f49a4d1d10_z.jpg'
    //        })
    //        .selector('#wheat')
    //        .css({
    //            'background-image': 'https://farm3.staticflickr.com/2660/3715569167_7e978e8319_b.jpg'
    //        }),
    //
    //    elements: {
    //        nodes: [
    //            { data: { id: 'cat' } },
    //            { data: { id: 'bird' } },
    //            { data: { id: 'ladybug' } },
    //            { data: { id: 'aphid' } },
    //            { data: { id: 'rose' } },
    //            { data: { id: 'grasshopper' } },
    //            { data: { id: 'plant' } },
    //            { data: { id: 'wheat' } }
    //        ],
    //        edges: [
    //            { data: { source: 'cat', target: 'wheat'} },
    //            { data: { source: 'bird', target: 'wheat' } },
    //            { data: { source: 'grasshopper', target: 'wheat' } },
    //            { data: { source: 'rose', target: 'wheat'} },
    //            { data: { source: 'plant', target: 'wheat'} },
    //            { data: { source: 'ladybug', target: 'wheat' } },
    //            { data: { source: 'aphid', target: 'wheat' } }
    //        ]
    //    },
    //
    //    layout: {
    //        name: 'breadthfirst',
    //        directed: true,
    //        padding: 0
    //    }
    //}); // cy init
    //
    //cy.on('tap', 'node', function(){
    //    var nodes = this;
    //    var tapped = nodes;
    //    var food = [];
    //
    //    nodes.addClass('eater');
    //
    //    for(;;){
    //        var connectedEdges = nodes.connectedEdges(function(){
    //            return !this.target().anySame( nodes );
    //        });
    //
    //        var connectedNodes = connectedEdges.targets();
    //
    //        Array.prototype.push.apply( food, connectedNodes );
    //
    //        nodes = connectedNodes;
    //
    //        if( nodes.empty() ){ break; }
    //    }
    //
    //    var delay = 0;
    //    var duration = 500;
    //    for( var i = food.length - 1; i >= 0; i-- ){ (function(){
    //        var thisFood = food[i];
    //        var eater = thisFood.connectedEdges(function(){
    //            return this.target().same(thisFood);
    //        }).source();
    //
    //        thisFood.delay( delay, function(){
    //            eater.addClass('eating');
    //        } ).animate({
    //            position: eater.position(),
    //            css: {
    //                'width': 10,
    //                'height': 10,
    //                'border-width': 0,
    //                'opacity': 0
    //            }
    //        }, {
    //            duration: duration,
    //            complete: function(){
    //                thisFood.remove();
    //            }
    //        });
    //
    //        delay += duration;
    //    })(); } // for
    //
    //}); // on tap
    //alert(JSON.stringify(nodes, null, 4));
    //alert(JSON.stringify(links, null, 4));
    //
    //nodes.forEach(function(element, index, array){
    //    alert(JSON.stringify(element, null, 4));
    //});

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
                    'background-color': 'white',
                    'label': 'data(name)',
                    'shape': 'ellipse',
                    'width': 'label',
                    'text-valign' : 'center',
                    'text-halign' : 'center',
                    'font-size' : 12
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
            directed: false, // whether the tree is directed downwards (or edges can point in any direction if false)
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

});
