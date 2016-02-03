// Получение корзины
function GetCartAjax(){
	ajax('cart', 'GetCartPage', false, 'html').done(function(data){
		//console.log(data);
		$('#cart > .modal_container').html(data);
		openObject('cart');
	});
	// if($('#cart').hasClass('opened')){
	// 	closeObject('cart');
	// }else{
	// 	$.ajax({
	// 		url: URL_base+'cart'
	// 	}).done(function(data){
	// 		var res = data.match(/<!-- CART -->([\s\S]*)\<!-- END CART -->/);
	// 		$('#cart > .modal_container').html(res[1]);
	// 		openObject('cart');
	// 	});
	// }
}

// Получение списка товаров в кабинете
function GetCabProdAjax(id_order){
	ajax('cabinet', 'GetProdList', {'id_order': id_order}, 'html').done(function(data){
		//console.log(data);
		$('.mdl-tabs__panel > #products').html(data);
	});
}

// Получение списка товаров по каждомк заказу в кабинете совместныйх покупок
function GetCabCoopProdAjax(id_cart){
	ajax('cabinet', 'GetProdListForCart', {'id_cart': id_cart}, 'html').done(function(data){
		//console.log(data);
		$('#products_cart').html(data);
	});
}

// lib d3
/*function foo(selection) {
  selection
      .attr("name1", "value1")
      .attr("name2", "value2");
}*/

function Graf3d(){
	// Parallel Coordinates
	// Copyright (c) 2012, Kai Chang
	// Released under the BSD License: http://opensource.org/licenses/BSD-3-Clause

	//var width = document.body.clientWidth,
	//height = d3.max([document.body.clientHeight-540, 240]);
	var width = 900,
	    height = 260;

	var m = [60, 0, 10, 0],
	    /*w = width - m[1] - m[3],
	    h = height - m[0] - m[2],*/
	    w = width,
	    h = height,
	    xscale = d3.scale.ordinal().rangePoints([0, w], 1),
	    yscale = {},
	    dragging = {},
	    line = d3.svg.line(),
	    axis = d3.svg.axis().orient("left").ticks(1+height/50),
	    data,
	    foreground,
	    background,
	    highlighted,
	    dimensions,
	    legend,
	    render_speed = 50,
	    brush_count = 0,
	    excluded_groups = [];

	var colors = {
	  "Baby Foods": [185,56,73],
	  "Baked Products": [37,50,75],
	  "Beef Products": [325,50,39],
	  "Beverages": [10,28,67],
	  "Breakfast Cereals": [271,39,57],
	  "Cereal Grains and Pasta": [56,58,73],
	  "Dairy and Egg Products": [28,100,52],
	  "Ethnic Foods": [41,75,61],
	  "Fast Foods": [60,86,61],
	  "Fats and Oils": [30,100,73],
	  "Finfish and Shellfish Products": [318,65,67],
	  "Fruits and Fruit Juices": [274,30,76],
	  "Lamb, Veal, and Game Products": [20,49,49],
	  "Legumes and Legume Products": [334,80,84],
	  "Meals, Entrees, and Sidedishes": [185,80,45],
	  "Nut and Seed Products": [10,30,42],
	  "Pork Products": [339,60,49],
	  "Poultry Products": [359,69,49],
	  "Restaurant Foods": [204,70,41],
	  "Sausages and Luncheon Meats": [1,100,79],
	  "Snacks": [189,57,75],
	  "Soups, Sauces, and Gravies": [110,57,70],
	  "Spices and Herbs": [214,55,79],
	  "Sweets": [339,60,75],
	  "Vegetables and Vegetable Products": [120,56,40]
	};

	// Scale chart and canvas height
	d3.select("#chart")
	    .style("height", (h) + "px")

	d3.selectAll("canvas")
	    .attr("width", w)
	    .attr("height", h)
	    .style("padding", m.join("px ") + "px");


	// Foreground canvas for primary view
	foreground = document.getElementById('foreground').getContext('2d');
	foreground.globalCompositeOperation = "destination-over";
	foreground.strokeStyle = "rgba(0,100,160,0.1)";
	foreground.lineWidth = 1.7;
	foreground.fillText("Loading...",w/2,h/2);

	// Highlight canvas for temporary interactions
	highlighted = document.getElementById('highlight').getContext('2d');
	highlighted.strokeStyle = "rgba(0,100,160,1)";
	highlighted.lineWidth = 4;

	// Background canvas
	background = document.getElementById('background').getContext('2d');
	background.strokeStyle = "rgba(0,100,160,0.1)";
	background.lineWidth = 1.7;

	// SVG for ticks, labels, and interactions
	var svg = d3.select("svg")
	    .attr("width", w)
	    .attr("height", h)
	  .append("svg:g")
	    .attr("transform", "translate(" + m[3] + "," + m[0] + ")");

	// Load the data and visualization
	//d3.csv(URL_base+"js/nutrients.csv", function(raw_data) {
	  // Convert quantitative scales to floats

	// Load the data and visualization
	d3.json(URL_base+"js/nutrients.json", function(raw_data) {
	    //map = JSON.parse(user);

	    var raw = new Array();
	    raw = raw_data;

	    console.log(raw);
		data = raw.map(function(d) {
			for (var k in d) {
				console.log(k,d);
				if (!_.isNaN(raw_data[0][k] - 0) && k != 'id') {
					d[k] = parseFloat(d[k]) || 0;
					console.log(d[k]);
					console.log(parseFloat(d[k]));
				}
			};
			return d;
		});
		console.log(data);

	  // Extract the list of numerical dimensions and create a scale for each.
	  xscale.domain(dimensions = d3.keys(data[0]).filter(function(k) {
	    return (_.isNumber(data[0][k])) && (yscale[k] = d3.scale.linear()
	      .domain(d3.extent(data, function(d) { return +d[k]; }))
	      .range([h, 0]));
	  }).sort());

	  // Add a group element for each dimension.
	  var g = svg.selectAll(".dimension")
	      .data(dimensions)
	    .enter().append("svg:g")
	      .attr("class", "dimension")
	      .attr("transform", function(d) { return "translate(" + xscale(d) + ")"; })
	      .call(d3.behavior.drag()
	        .on("dragstart", function(d) {
	          dragging[d] = this.__origin__ = xscale(d);
	          this.__dragged__ = false;
	          d3.select("#foreground").style("opacity", "0.35");
	        })
	        .on("drag", function(d) {
	          dragging[d] = Math.min(w, Math.max(0, this.__origin__ += d3.event.dx));
	          dimensions.sort(function(a, b) { return position(a) - position(b); });
	          xscale.domain(dimensions);
	          g.attr("transform", function(d) { return "translate(" + position(d) + ")"; });
	          brush_count++;
	          this.__dragged__ = true;

	          // Feedback for axis deletion if dropped
	          if (dragging[d] < 12 || dragging[d] > w-12) {
	            d3.select(this).select(".background").style("fill", "#b00");
	          } else {
	            d3.select(this).select(".background").style("fill", null);
	          }
	        })
	        .on("dragend", function(d) {
	          if (!this.__dragged__) {
	            // no movement, invert axis
	            var extent = invert_axis(d);

	          } else {
	            // reorder axes
	            d3.select(this).transition().attr("transform", "translate(" + xscale(d) + ")");

	            var extent = yscale[d].brush.extent();
	          }

	          // remove axis if dragged all the way left
	          if (dragging[d] < 12 || dragging[d] > w-12) {
	            remove_axis(d,g);
	          }

	          // TODO required to avoid a bug
	          xscale.domain(dimensions);
	          update_ticks(d, extent);

	          // rerender
	          d3.select("#foreground").style("opacity", null);
	          brush();
	          delete this.__dragged__;
	          delete this.__origin__;
	          delete dragging[d];
	        }))

	  // Add an axis and title.
	  g.append("svg:g")
	      .attr("class", "axis")
	      .attr("transform", "translate(0,0)")
	      .each(function(d) { d3.select(this).call(axis.scale(yscale[d])); })
	    .append("svg:text")
	      .attr("text-anchor", "middle")
	      .attr("y", function(d,i) { return i%2 == 0 ? -14 : -30 } )
	      .attr("x", 0)
	      .attr("class", "label")
	      .text(String)
	      .append("title")
	        .text("Click to invert. Drag to reorder");

	  // Add and store a brush for each axis.
	  g.append("svg:g")
	      .attr("class", "brush")
	      .each(function(d) { d3.select(this).call(yscale[d].brush = d3.svg.brush().y(yscale[d]).on("brush", brush)); })
	    .selectAll("rect")
	      .style("visibility", null)
	      .attr("x", -23)
	      .attr("width", 36)
	      .append("title")
	        .text("Drag up or down to brush along this axis");

	  g.selectAll(".extent")
	      .append("title")
	        .text("Drag or resize this filter");


	  legend = create_legend(colors,brush);

	  // Render full foreground
	  brush();

	});

	// copy one canvas to another, grayscale
	function gray_copy(source, target) {
	  var pixels = source.getImageData(0,0,w,h);
	  target.putImageData(grayscale(pixels),0,0);
	}

	// http://www.html5rocks.com/en/tutorials/canvas/imagefilters/
	function grayscale(pixels, args) {
	  var d = pixels.data;
	  for (var i=0; i<d.length; i+=4) {
	    var r = d[i];
	    var g = d[i+1];
	    var b = d[i+2];
	    // CIE luminance for the RGB
	    // The human eye is bad at seeing red and blue, so we de-emphasize them.
	    var v = 0.2126*r + 0.7152*g + 0.0722*b;
	    d[i] = d[i+1] = d[i+2] = v
	  }
	  return pixels;
	};

	function create_legend(colors,brush) {
	  // create legend
	  var legend_data = d3.select("#legend")
	    .html("")
	    .selectAll(".row")
	    .data( _.keys(colors).sort() )

	  // filter by group
	  var legend = legend_data
	    .enter().append("div")
	      .attr("title", "Hide group")
	      .on("click", function(d) {
	        // toggle food group
	        if (_.contains(excluded_groups, d)) {
	          d3.select(this).attr("title", "Hide group")
	          excluded_groups = _.difference(excluded_groups,[d]);
	          brush();
	        } else {
	          d3.select(this).attr("title", "Show group")
	          excluded_groups.push(d);
	          brush();
	        }
	      });

	  legend
	    .append("span")
	    .style("background", function(d,i) { return color(d,0.85)})
	    .attr("class", "color-bar");

	  legend
	    .append("span")
	    .attr("class", "tally")
	    .text(function(d,i) { return 0});

	  legend
	    .append("span")
	    .text(function(d,i) { return " " + d});

	  return legend;
	}

	// render polylines i to i+render_speed
	function render_range(selection, i, max, opacity) {
	  selection.slice(i,max).forEach(function(d) {
	    path(d, foreground, color(d.group,opacity));
	  });
	};

	// simple data table
	function data_table(sample) {
	  // sort by first column
	  var sample = sample.sort(function(a,b) {
	    var col = d3.keys(a)[0];
	    return a[col] < b[col] ? -1 : 1;
	  });

	  var table = d3.select("#food-list")
	    .html("")
	    .selectAll(".row")
	      .data(sample)
	    .enter().append("div")
	      .on("mouseover", highlight)
	      .on("mouseout", unhighlight);

	  table
	    .append("span")
	      .attr("class", "color-block")
	      .style("background", function(d) { return color(d.group,0.85) })

	  table
	    .append("span")
	      .text(function(d) { return d.name; })
	}

	// Adjusts rendering speed
	function optimize(timer) {
	  var delta = (new Date()).getTime() - timer;
	  render_speed = Math.max(Math.ceil(render_speed * 30 / delta), 8);
	  render_speed = Math.min(render_speed, 300);
	  return (new Date()).getTime();
	}

	// Feedback on rendering progress
	function render_stats(i,n,render_speed) {
	  d3.select("#rendered-count").text(i);
	  d3.select("#rendered-bar")
	    .style("width", (100*i/n) + "%");
	  d3.select("#render-speed").text(render_speed);
	}

	// Feedback on selection
	function selection_stats(opacity, n, total) {
	  d3.select("#data-count").text(total);
	  d3.select("#selected-count").text(n);
	  d3.select("#selected-bar").style("width", (100*n/total) + "%");
	  d3.select("#opacity").text((""+(opacity*100)).slice(0,4) + "%");
	}

	// Highlight single polyline
	function highlight(d) {
	  d3.select("#foreground").style("opacity", "0.25");
	  d3.selectAll(".row").style("opacity", function(p) { return (d.group == p) ? null : "0.3" });
	  path(d, highlighted, color(d.group,1));
	}

	// Remove highlight
	function unhighlight() {
	  d3.select("#foreground").style("opacity", null);
	  d3.selectAll(".row").style("opacity", null);
	  highlighted.clearRect(0,0,w,h);
	}

	function invert_axis(d) {
	  // save extent before inverting
	  if (!yscale[d].brush.empty()) {
	    var extent = yscale[d].brush.extent();
	  }
	  if (yscale[d].inverted == true) {
	    yscale[d].range([h, 0]);
	    d3.selectAll('.label')
	      .filter(function(p) { return p == d; })
	      .style("text-decoration", null);
	    yscale[d].inverted = false;
	  } else {
	    yscale[d].range([0, h]);
	    d3.selectAll('.label')
	      .filter(function(p) { return p == d; })
	      .style("text-decoration", "underline");
	    yscale[d].inverted = true;
	  }
	  return extent;
	}

	// Draw a single polyline
	/*
	function path(d, ctx, color) {
	  if (color) ctx.strokeStyle = color;
	  var x = xscale(0)-15;
	      y = yscale[dimensions[0]](d[dimensions[0]]);   // left edge
	  ctx.beginPath();
	  ctx.moveTo(x,y);
	  dimensions.map(function(p,i) {
	    x = xscale(p),
	    y = yscale[p](d[p]);
	    ctx.lineTo(x, y);
	  });
	  ctx.lineTo(x+15, y);                               // right edge
	  ctx.stroke();
	}
	*/

	function path(d, ctx, color) {
	  if (color) ctx.strokeStyle = color;
	  ctx.beginPath();
	  var x0 = xscale(0)-15,
	      y0 = yscale[dimensions[0]](d[dimensions[0]]);   // left edge
	  ctx.moveTo(x0,y0);
	  dimensions.map(function(p,i) {
	    var x = xscale(p),
	        y = yscale[p](d[p]);
	    var cp1x = x - 0.88*(x-x0);
	    var cp1y = y0;
	    var cp2x = x - 0.12*(x-x0);
	    var cp2y = y;
	    ctx.bezierCurveTo(cp1x, cp1y, cp2x, cp2y, x, y);
	    x0 = x;
	    y0 = y;
	  });
	  ctx.lineTo(x0+15, y0);                               // right edge
	  ctx.stroke();
	};

	function color(d,a) {
	  var c = colors[d];
	  //return ["hsla(",c[0],",",c[1],"%,",c[2],"%,",a,")"].join("");
	  return ["hsl(120,100%,25%)"].join("");
	}

	function position(d) {
	  var v = dragging[d];
	  return v == null ? xscale(d) : v;
	}

	// Handles a brush event, toggling the display of foreground lines.
	// TODO refactor
	function brush() {
	  brush_count++;
	  var actives = dimensions.filter(function(p) { return !yscale[p].brush.empty(); }),
	      extents = actives.map(function(p) { return yscale[p].brush.extent(); });

	  // hack to hide ticks beyond extent
	  var b = d3.selectAll('.dimension')[0]
	    .forEach(function(element, i) {
	      var dimension = d3.select(element).data()[0];
	      if (_.include(actives, dimension)) {
	        var extent = extents[actives.indexOf(dimension)];
	        d3.select(element)
	          .selectAll('text')
	          .style('font-weight', 'bold')
	          .style('font-size', '13px')
	          .style('display', function() {
	            var value = d3.select(this).data();
	            return extent[0] <= value && value <= extent[1] ? null : "none"
	          });
	      } else {
	        d3.select(element)
	          .selectAll('text')
	          .style('font-size', null)
	          .style('font-weight', null)
	          .style('display', null);
	      }
	      d3.select(element)
	        .selectAll('.label')
	        .style('display', null);
	    });
	    ;

	  // bold dimensions with label
	  d3.selectAll('.label')
	    .style("font-weight", function(dimension) {
	      if (_.include(actives, dimension)) return "bold";
	      return null;
	    });

	  // Get lines within extents
	  var selected = [];
	  data
	    .filter(function(d) {
	      return !_.contains(excluded_groups, d.group);
	    })
	    .map(function(d) {
	      return actives.every(function(p, dimension) {
	        return extents[dimension][0] <= d[p] && d[p] <= extents[dimension][1];
	      }) ? selected.push(d) : null;
	    });

	  // free text search
	  var query = d3.select("#search")[0][0].value;
	  if (query.length > 0) {
	    selected = search(selected, query);
	  }

	  if (selected.length < data.length && selected.length > 0) {
	    d3.select("#keep-data").attr("disabled", null);
	    d3.select("#exclude-data").attr("disabled", null);
	  } else {
	    d3.select("#keep-data").attr("disabled", "disabled");
	    d3.select("#exclude-data").attr("disabled", "disabled");
	  };

	  // total by food group
	  var tallies = _(selected)
	    .groupBy(function(d) { return d.group; })

	  // include empty groups
	  _(colors).each(function(v,k) { tallies[k] = tallies[k] || []; });

	  legend
	    .style("text-decoration", function(d) { return _.contains(excluded_groups,d) ? "line-through" : null; })
	    .attr("class", function(d) {
	      return (tallies[d].length > 0)
	           ? "row"
	           : "row off";
	    });

	  legend.selectAll(".color-bar")
	    .style("width", function(d) {
	      return Math.ceil(600*tallies[d].length/data.length) + "px"
	    });

	  legend.selectAll(".tally")
	    .text(function(d,i) { return tallies[d].length });

	  // Render selected lines
	  paths(selected, foreground, brush_count, true);
	}

	// render a set of polylines on a canvas
	function paths(selected, ctx, count) {
	  var n = selected.length,
	      i = 0,
	      opacity = d3.min([2/Math.pow(n,0.3),1]),
	      timer = (new Date()).getTime();

	  selection_stats(opacity, n, data.length)

	  shuffled_data = _.shuffle(selected);

	  data_table(shuffled_data.slice(0,25));

	  ctx.clearRect(0,0,w+1,h+1);

	  // render all lines until finished or a new brush event
	  function animloop(){
	    if (i >= n || count < brush_count) return true;
	    var max = d3.min([i+render_speed, n]);
	    render_range(shuffled_data, i, max, opacity);
	    render_stats(max,n,render_speed);
	    i = max;
	    timer = optimize(timer);  // adjusts render_speed
	  };

	  d3.timer(animloop);
	}

	// transition ticks for reordering, rescaling and inverting
	function update_ticks(d, extent) {
	  // update brushes
	  if (d) {
	    var brush_el = d3.selectAll(".brush")
	        .filter(function(key) { return key == d; });
	    // single tick
	    if (extent) {
	      // restore previous extent
	      brush_el.call(yscale[d].brush = d3.svg.brush().y(yscale[d]).extent(extent).on("brush", brush));
	    } else {
	      brush_el.call(yscale[d].brush = d3.svg.brush().y(yscale[d]).on("brush", brush));
	    }
	  } else {
	    // all ticks
	    d3.selectAll(".brush")
	      .each(function(d) { d3.select(this).call(yscale[d].brush = d3.svg.brush().y(yscale[d]).on("brush", brush)); })
	  }

	  brush_count++;

	  show_ticks();

	  // update axes
	  d3.selectAll(".axis")
	    .each(function(d,i) {
	      // hide lines for better performance
	      d3.select(this).selectAll('line').style("display", "none");

	      // transition axis numbers
	      d3.select(this)
	        .transition()
	        .duration(720)
	        .call(axis.scale(yscale[d]));

	      // bring lines back
	      d3.select(this).selectAll('line').transition().delay(800).style("display", null);

	      d3.select(this)
	        .selectAll('text')
	        .style('font-weight', null)
	        .style('font-size', null)
	        .style('display', null);
	    });
	}

	// Rescale to new dataset domain
	function rescale() {
	  // reset yscales, preserving inverted state
	  dimensions.forEach(function(d,i) {
	    if (yscale[d].inverted) {
	      yscale[d] = d3.scale.linear()
	          .domain(d3.extent(data, function(p) { return +p[d]; }))
	          .range([0, h]);
	      yscale[d].inverted = true;
	    } else {
	      yscale[d] = d3.scale.linear()
	          .domain(d3.extent(data, function(p) { return +p[d]; }))
	          .range([h, 0]);
	    }
	  });

	  update_ticks();

	  // Render selected data
	  paths(data, foreground, brush_count);
	}

	// Get polylines within extents
	function actives() {
	  var actives = dimensions.filter(function(p) { return !yscale[p].brush.empty(); }),
	      extents = actives.map(function(p) { return yscale[p].brush.extent(); });

	  // filter extents and excluded groups
	  var selected = [];
	  data
	    .filter(function(d) {
	      return !_.contains(excluded_groups, d.group);
	    })
	    .map(function(d) {
	    return actives.every(function(p, i) {
	      return extents[i][0] <= d[p] && d[p] <= extents[i][1];
	    }) ? selected.push(d) : null;
	  });

	  // free text search
	  var query = d3.select("#search")[0][0].value;
	  if (query > 0) {
	    selected = search(selected, query);
	  }

	  return selected;
	}

	// Export data
	function export_csv() {
	  var keys = d3.keys(data[0]);
	  var rows = actives().map(function(row) {
	    return keys.map(function(k) { return row[k]; })
	  });
	  var csv = d3.csv.format([keys].concat(rows)).replace(/\n/g,"<br/>\n");
	  var styles = "<style>body { font-family: sans-serif; font-size: 12px; }</style>";
	  window.open("text/csv").document.write(styles + csv);
	}

	// scale to window size
	window.onresize = function() {
	  width = 900,
	  height = 260;

	  w = width,
	  h = height;

	  d3.select("#chart")
	      .style("height", (h) + "px")

	  d3.selectAll("canvas")
	      .attr("width", w)
	      .attr("height", h)
	      .style("padding", m.join("px ") + "px");

	  d3.select("svg")
	      .attr("width", w)
	      .attr("height", h)
	    .select("g")
	      .attr("transform", "translate(" + m[3] + "," + m[0] + ")");

	  xscale = d3.scale.ordinal().rangePoints([0, w], 1).domain(dimensions);
	  dimensions.forEach(function(d) {
	    yscale[d].range([h, 0]);
	  });

	  d3.selectAll(".dimension")
	    .attr("transform", function(d) { return "translate(" + xscale(d) + ")"; })
	  // update brush placement
	  d3.selectAll(".brush")
	    .each(function(d) { d3.select(this).call(yscale[d].brush = d3.svg.brush().y(yscale[d]).on("brush", brush)); })
	  brush_count++;

	  // update axis placement
	  axis = axis.ticks(1+height/50),
	  d3.selectAll(".axis")
	    .each(function(d) { d3.select(this).call(axis.scale(yscale[d])); });

	  // render data
	  brush();
	};

	// Remove all but selected from the dataset
	function keep_data() {
	  new_data = actives();
	  if (new_data.length == 0) {
	    alert("I don't mean to be rude, but I can't let you remove all the data.\n\nTry removing some brushes to get your data back. Then click 'Keep' when you've selected data you want to look closer at.");
	    return false;
	  }
	  data = new_data;
	  rescale();
	}

	// Exclude selected from the dataset
	function exclude_data() {
	  new_data = _.difference(data, actives());
	  if (new_data.length == 0) {
	    alert("I don't mean to be rude, but I can't let you remove all the data.\n\nTry selecting just a few data points then clicking 'Exclude'.");
	    return false;
	  }
	  data = new_data;
	  rescale();
	}

	function remove_axis(d,g) {
	  dimensions = _.difference(dimensions, [d]);
	  xscale.domain(dimensions);
	  g.attr("transform", function(p) { return "translate(" + position(p) + ")"; });
	  g.filter(function(p) { return p == d; }).remove();
	  update_ticks();
	}

	d3.select("#keep-data").on("click", keep_data);
	d3.select("#exclude-data").on("click", exclude_data);
	d3.select("#export-data").on("click", export_csv);
	d3.select("#search").on("keyup", brush);


	// Appearance toggles
	d3.select("#hide-ticks").on("click", hide_ticks);
	d3.select("#show-ticks").on("click", show_ticks);
	d3.select("#dark-theme").on("click", dark_theme);
	d3.select("#light-theme").on("click", light_theme);

	function hide_ticks() {
	  d3.selectAll(".axis g").style("display", "none");
	  //d3.selectAll(".axis path").style("display", "none");
	  d3.selectAll(".background").style("visibility", "hidden");
	  d3.selectAll("#hide-ticks").attr("disabled", "disabled");
	  d3.selectAll("#show-ticks").attr("disabled", null);
	};

	function show_ticks() {
	  d3.selectAll(".axis g").style("display", null);
	  //d3.selectAll(".axis path").style("display", null);
	  d3.selectAll(".background").style("visibility", null);
	  d3.selectAll("#show-ticks").attr("disabled", "disabled");
	  d3.selectAll("#hide-ticks").attr("disabled", null);
	};

	function dark_theme() {
	  d3.select("body").attr("class", "dark");
	  d3.selectAll("#dark-theme").attr("disabled", "disabled");
	  d3.selectAll("#light-theme").attr("disabled", null);
	}

	function light_theme() {
	  d3.select("body").attr("class", null);
	  d3.selectAll("#light-theme").attr("disabled", "disabled");
	  d3.selectAll("#dark-theme").attr("disabled", null);
	}

	function search(selection,str) {
	  pattern = new RegExp(str,"i")
	  return _(selection).filter(function(d) { return pattern.exec(d.name); });
	}

}























function ModalGraph(id_graphics){
	ajax('product', 'OpenModalGraph').done(function(data){
		$('#graph').html(data);
		componentHandler.upgradeDom();

		if(id_graphics){
			//console.log(id_graphics);
				//$('a').on('click', function(){
				//var id_graphics = $(this).attr('id');
				ajax('product', 'SearchGraph', {'id_graphics': id_graphics}, 'html').done(function(data){
					if(data != null){
						//console.log(data);
						$('#graph').html(data);
						//foo(d3.selectAll("div").text('some text'));

						componentHandler.upgradeDom();
						openObject('graph');
						$('#graph #user_bt').find('a').addClass('update');
						$('#graph').on('click', '.update', function(){
							var parent =  $(this).closest('#graph'),
								id_category = parent.data('target'),
								opt = 0,
								name_user = parent.find('#name_user').val(),
								text = parent.find('textarea').val(),
								arr = parent.find('input[type="range"]'),
								values = {};
							if($('.select_go label').is(':checked')){
								opt = 1;
							}
							arr.each(function(index, val){
								values[index] = $(val).val();
							});
							ajax('product', 'UpdateGraph', {'values': values, 'id_category': id_category, 'id_graphics': id_graphics, 'name_user': name_user, 'text': text, 'opt': opt}).done(function(data){
								if(data === true){
									console.log('Your data has been saved successfully!');
									closeObject('graph');
									location.reload();
								}else{
									console.log('Something goes wrong!');
								}
							});
						});
					}else{
						console.log('Something goes wrong!');
					}
				});


		}else{
			openObject('graph');
			$('#graph').on('click', '.btn_js.save', function(){
				var parent =  $(this).closest('#graph'),
					id_category = parent.data('target'),
					opt = 0,
					name_user = parent.find('#name_user').val(),
					text = parent.find('textarea').val(),
					arr = parent.find('input[type="range"]'),
					values = {};
				if ($('.select_go label').is(':checked')) {
					opt = 1;
				}
				arr.each(function(index, val){
					values[index] = $(val).val();
				});
				ajax('product', 'SaveGraph', {'values': values, 'id_category': id_category, 'name_user': name_user, 'text': text, 'opt': opt}).done(function(data){
					if(data === true){
						console.log('Your data has been saved successfully!');
						closeObject('graph');
						location.reload();
					}else{
						console.log('Something goes wrong!');
					}
				});
			});
		};
	});
}

//function toArray(data){ return [].slice.call(data) }
/*function SaveGraph(){
	$('#graph').on('click', '.btn_js.save', function(){
		var parent =  $(this).closest('#graph'),
			id_category = parent.data('target'),
			opt = 0,
			name_user = parent.find('#name_user').val(),
			text = parent.find('textarea').val(),
			arr = parent.find('input[type="range"]'),
			values = {};
		if ($('.select_go label').is(':checked')) {
			var opt = 1;
		};
		arr.each(function(index, val){
			values[index] = $(val).val();
		});
		ajax('product', 'SaveGraph', {'values': values, 'id_category': id_category, 'name_user': name_user, 'text': text, 'opt': opt}).done(function(data){
			if(data === true){
				console.log('Your data has been saved successfully!');
				closeObject('graph');
				location.reload();
			}else{
				console.log('Something goes wrong!');
			}
		});
	});
}*/

/*function UpdateGraph(id_graphics){
	if(val == 0){
		$('a.updat').on('click', function(){
			var id_graphics = $(this).attr('id');
			ajax('product', 'SearchGraph', {'id_graphics': id_graphics}, 'html').done(function(data){
				//console.log(data);

				if(data != null){
					$('#graph .modal_container').html(data);
					// var ev = 'a.update';
					// $.each(data, function(index, el){

					// 	if(index.indexOf('value_') >= 0){
					// 		$('#graph .'+index).val(el).trigger('change');
					// 	}else{
					// 		console.log('err');
					// 	};
					// });
					componentHandler.upgradeDom();
					openObject('graph');
					//ModalGraph(ev);

				}else{
					console.log('Something goes wrong!');
				}
			});
		});
	}else{
		console.log('else');
	};
}*/

/*function GetGraphAjax(data){
	ajax('products', 'GetGraphList', {'id_category': id_category}, 'html').done(function(data){
		console.log(data);
		$('#graph > .modal_container').html(data);
	});
}*/

function ajax(target, action, data, dataType){
	if(typeof(data) == 'object'){
		data['target'] = target;
		data['action'] = action;
	}else{
		data = {'target': target, 'action': action};
	}
	dataType = dataType || 'json';
	var ajax = $.ajax({
		url: URL_base+'ajax',
		type: "POST",
		dataType : dataType,
		data: data
	});
	return ajax;
}

// Change product view
function ChangeView(view){
	if(view == 'list'){
		$('.prod_structure span.list').removeClass('disabled');
		$('#view_block_js').removeClass('module_view').addClass('list_view');
		$('#view_block_js .col-md-4').removeClass().addClass('col-md-12 clearfix');
		$('.prod_structure span.module').addClass('disabled');
	}else if(view == 'module'){
		$('.prod_structure span.module').removeClass('disabled');
		$('#view_block_js').removeClass('list_view').addClass('module_view');
		$('#view_block_js .col-md-12').removeClass().addClass('col-lg-3 col-md-4 col-sm-6 col-xs-12 clearfix');
		$('.prod_structure span.list').addClass('disabled');
	}
	ListenPhotoHover();
	document.cookie="product_view="+view+"; path=/";
}

// Previw Sliders
function ListenPhotoHover(){
	preview = $('.list_view .preview');
	previewOwl = preview.find('#owl-product_slide_js');
	$('.product_photo').on('mouseover', function(){
		if($('#view_block_js').hasClass('list_view')){
			if($(this).hasClass('hovered')){
			}else{
				showPreview(1);
				// console.log('enter');
				$(this).addClass('hovered');
				// console.log('hover');
				rebuildPreview($(this));
			}
		}
	}).on('mouseleave', function(e){
		if($('#view_block_js').hasClass('list_view')){
			var mp = mousePos(e),
				obj = $(this),
				obj2 = $('.product_photo.hovered');
			// console.log(mp.x+'x'+mp.y);
			// console.log(preview.offset().left+'x'+preview.offset().top);
			// console.log(parseFloat(preview.offset().left+preview.width())+'x'+parseFloat(preview.offset().top+preview.height()));
			if((mp.x >= preview.offset().left && mp.x <= preview.offset().left+preview.width() && mp.y >= preview.offset().top && mp.y <= preview.offset().top+preview.height())
				|| (obj.hasClass('hovered') && mp.x >= obj.offset().left && mp.x <= obj.offset().left+obj.width() && mp.y >= obj.offset().top && mp.y <= obj.offset().top+obj.height())){
				// console.log('hover2');
			}else{
				// console.log('hide');
				hidePreview();
				obj.removeClass('hovered');
			}
		}
		return;
	});
	preview.on('mouseleave', function(e){
		if($('#view_block_js').hasClass('list_view')){
			mp = mousePos(e);
			obj = $('.product_photo.hovered');
			if(obj.hasClass('hovered') && mp.x >= obj.offset().left && mp.x <= obj.offset().left+obj.width() && mp.y >= obj.offset().top && mp.y <= obj.offset().top+obj.height()){
				// console.log('hovered_back');
			}else{
				// console.log('hide2');
				hidePreview();
				obj.removeClass('hovered');
			}
		}
	});
}

function hidePreview(){
	preview.hide().addClass('ajax_loading');
	if(previewOwl.data('owlCarousel')){
		previewOwl.data('owlCarousel').destroy();
	}
}

function rebuildPreview(obj){
	var position = obj.offset(),
		positionProd = $('#view_block_js').offset(),
		id_product = obj.closest('.card').find('.product_buy').data('idproduct'),
		// Calculating position of preview window
		viewportWidth = $(window).width(),
		viewportHeight = $(window).height(),
		pos = getScrollWindow(),
		correctionBottom = correctionTop = 0,
		marginBottom = marginTop = 15;
	if(pos > 50){
		marginTop += $('header').outerHeight();
	}
	var ovftop = position.top - preview.height()/2 + obj.height()/2 - marginTop,
		ovfbotton = position.top + preview.height()/2 + obj.height()/2 + marginBottom;
	if(pos + viewportHeight < ovfbotton){
		// console.log('overflow Bottom');
		correctionBottom = ovfbotton - (pos + viewportHeight);
	}else if(pos > ovftop){
		// console.log('overflow Top');
		correctionTop = ovftop - pos;
	}
	preview.css({
		top: position.top - positionProd.top - preview.height()/2 + obj.height()/2 - correctionBottom - correctionTop,
		left: 100,
	});
	if(position.top - preview.offset().top + obj.height()/2 + preview.find('.triangle').height() > preview.height() ){
		preview.css('border-radius', '5px 5px 5px 0').find('.triangle').css({
			top: '50%',
			left: 20,
		});
	}else if(preview.offset().top > position.top + obj.height()/2 - preview.find('.triangle').height()){
		preview.css('border-radius', '0 5px 5px 5px').find('.triangle').css({
			top: '50%',
			left: 20,
		});
	}else{
		preview.css('border-radius', '5px').find('.triangle').css({
			top: position.top - preview.offset().top + obj.height()/2,
			left: -7,
		});
	}
	// Sending ajax for collectiong data about hovered product
	if(obj.hasClass('hovered')){
		ajax('product', 'get_array_product', {'id_product': id_product}, 'html').done(function(data){
			preview.find('.preview_content').html(data);
			componentHandler.upgradeDom();
			showPreview(0);
		});
	}else{
		preview.hide();
	}
}
/** Определение расстояния прокрутки страницы */
function getScrollWindow() {
	var html = document.documentElement;
	var body = document.body;
	var top = html.scrollTop || body && body.scrollTop || 0;
	top -= html.clientTop;
	return top;
}
function changeToTop(pos){
	var totop = $('#toTop');
	if(pos > $('html').height()/8){
		if(totop.hasClass('visible') == false){
			totop.addClass('visible');
		}
	}else{
		if(totop.hasClass('visible')){
			totop.removeClass('visible');
		}
	}
}

function showPreview(ajax){
	if(ajax == 0){
		preview.find('#owl-product_slide_js').owlCarousel({
			singleItem: true,
			lazyLoad: true,
			lazyFollow: false,
			nav: true,
			dots: true,
			navContainer: true
		});
		setTimeout(function(){
			preview.removeClass('ajax_loading');
		}, 200);
	}else{
		preview.show();
	}
}

// get mouse position
function mousePos(e){
	var X = e.pageX; // положения по оси X
	var Y = e.pageY; // положения по оси Y
	return {"x":X, "y":Y};
}

/* Смена отображаемой цены */
function ChangePriceRange(id, sum){
	document.cookie="sum_range="+id+"; path=/";
	document.cookie="manual=1; path=/";
	$('li.sum_range').removeClass('active');
	$('li.sum_range_'+id).addClass('active');
	sum = 'Еще заказать на '+sum;
	$('.order_balance').text(sum);

	//console.log(sum);

	// setTimeout(function(){
	//  $('.product_buy .active_price').stop(true,true).css({
	//      "background-color": "#97FF99"
	//      //"color": "black"
	//  }).delay(1000).animate({
	//      "background-color": "transparent"
	//      //"color": "red"
	//  }, 3000);

	// },300);
}

function openObject(id){
	var object = $('#'+id),
		type = object.data('type');
	if($('body').hasClass('active_bg')){
		$('.opened:not([id="'+object.attr('id')+'"])').each(function(index, el) {
			closeObject($(this).attr('id'));
		});
	}
	if(object.hasClass('opened') && type != "search"){
		closeObject(object.attr('id'));
		DeactivateBG();
	}else{
		if(type == 'modal'){
			object.find('.modal_container').css({
				'max-height': $(window)*0.8
			});
			Position(object.addClass('opened'));
		}else{
			object.addClass('opened');
		}
		ActivateBG();
	}
	$(document).keyup(function(e){
		if(e.keyCode == 27){
			closeObject(object.attr('id'));
		}
	});
}

function closeObject(id){
	if(id == undefined){
		$('.opened').each(function(index, el) {
			closeObject($(this).attr('id'));
		});
	}else{
		$('#'+id).removeClass('opened');
		if(id == 'phone_menu'){
			$('[data-name="phone_menu"]').html('menu');
		};
	}
	DeactivateBG();
}
function Position(object){
	object.css({
		'top': ($(window).height() + 52 - object.outerHeight())/2,
		'left': ($(window).width() - object.outerWidth())/2
	});
}

//Активация подложки
function ActivateBG(){
	$('body').addClass('active_bg');
}
//Деактивация подложки
function DeactivateBG(){
	$('body').removeClass('active_bg');
}

//Закрытие Панели мобильного меню
function closePanel(){
	$('.menu').html('menu');
	$('.panel').slideUp();
}

// /*MODAL WINDOW*/

// // Вызов модального окна
// function openModal(target){
// 	$('body').addClass('active_modal');
// 	$('#'+target+'.modal_hidden').removeClass('modal_hidden').addClass('modal_opened');
// }
// // Закрытие модального окна
// function closeModal(){
// 	$('.modal_opened').removeClass('modal_opened').addClass('modal_hidden');
// 	$('body').removeClass('active_modal');
// }

//Установка выбранного рейтинга
function changestars(rating){
	$('.set_rating').each(function(){
		var star = $(this).next('i');
		if(parseInt($(this).val()) <= parseInt(rating)){
			star.text('star');
		}else{
			star.text('star_border');
		}
	});
}


// Выбор области (региона)
function GetRegions(){
	$.ajax({
		type: "post",
		url: URL_base+'ajax',
		dataType: "html",
		data: ({
			target: 'location',
			action: 'GetRegionsList'
		}),
	}).done(function(data){
		$('[for="region_select"]').html(data);
	});
}

// Выбор области (региона)
function GetCities(input){
	$.ajax({
		type: "post",
		url: URL_base+'ajax',
		dataType: "html",
		data: ({
			target: 'location',
			action: 'GetCitiesList',
			input: input
		}),
	}).done(function(data){
		$('[for="city_select"]').html(data);
	});
}

// Выбор службы доставки
function GetDeliveryService(input, service){
	$.ajax({
		type: "post",
		url: URL_base+'ajax',
		dataType: "html",
		data: ({
			target: 'location',
			action: 'GetDeliveryServicesList',
			input: input,
			service: service
		}),
	}).done(function(data){
		$('.delivery_service').html(data);
		componentHandler.upgradeDom();
	});
}

// Выбор службы доставки
function GetDeliveryMethods(service, city){
	$.ajax({
		type: "post",
		url: URL_base+'ajax',
		dataType: "html",
		data: ({
			target: 'location',
			action: 'GetAddressListDepartmentByCity',
			delivery_service: service,
			city: city
		}),
	}).done(function(data){
		$('.list_post_office').html(data);
	});
}

/** Валидация пароля **/
function ValidatePass(passwd){
	var protect = 0;
	var result;
	var small = new RegExp("^(?=.*[a-zа-я]).*$", "g");
	if(small.test(passwd)) {
		protect++;
	}

	var big = new RegExp("^(?=.*[A-ZА-Я]).*$", "g");
	if(big.test(passwd)) {
		protect++;
	}

	var numb = new RegExp("^(?=.*[0-9]).*$", "g");
	if(numb.test(passwd)) {
		protect++;
	}

	var vv = new RegExp("^(?=.*[!,@,#,$,%,^,&,*,?,_,~,-,=]).*$", "g");
	if(vv.test(passwd)) {
		protect++;
	}

	if(protect == 1) {
		$('#passwd + .mdl-textfield__error').empty();
		$('.mdl-textfield__error').closest('.mdl-textfield #passwd').attr('class', 'bad');
		result = false;
	}
	if(protect == 2) {
		$('.mdl-textfield__error').closest('.mdl-textfield #passwd').attr('class', 'better');
		result = false;
	}
	if(protect == 3) {
		$('.mdl-textfield__error').closest('.mdl-textfield #passwd').attr('class', 'ok');
		result = false;
	}
	if(protect == 4) {
		$('.mdl-textfield__error').closest('.mdl-textfield #passwd').attr('class', 'best');
		result = false;
	}
	if(passwd.length == 0){
		$('#passwd + .mdl-textfield__error').empty();
		$('#passstrengthlevel').attr('class', 'small');
		result = 'Введите пароль';
		$('#passwd + .mdl-textfield__error').append(result);
	}else if(passwd.length < 4) {
		$('#passwd + .mdl-textfield__error').empty();
		$('#passstrengthlevel').attr('class', 'small');
		result = 'Пароль слишком короткий';
		$('#passwd + .mdl-textfield__error').append(result);
	}
	return result;
}
var req = null;
/** Валидация email **/
function ValidateEmail(email, type){
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var name = $('#regs #name').val();
	var pass = $('#passwd').val();
	var passconfirm = $('#passwdconfirm').val();
	var error = '';
	/*var confirmps = $('#confirmps').prop('checked');*/
	var result;

	if (req != null) req.abort();

	req = ajax('auth', 'register', {email: email}).done(function(data){
		console.log(data);
		if(email.length == 0){
			$('#email + #email_error').empty();
			error = 'Введите email';
			$('#email + .mdl-textfield__error').append(error);
			$('#email').closest('.mdl-textfield ').addClass('is-invalid');
			result = false;
		}else if(!re.test(email)){
			$('#email + .mdl-textfield__error').empty();
			error = 'Введен некорректный email';
			$('#email + .mdl-textfield__error').append(error);
			$('#email').closest('.mdl-textfield ').addClass('is-invalid');
			result = false;
		}else if(data == "true"){

			$('#email ~ .mdl-textfield__error').empty();
			error = 'Пользователь с таким email уже зарегистрирован';
			$('#email ~ .mdl-textfield__error').append(error);
			$('#email').closest('.mdl-textfield ').addClass('is-invalid');
			result = false;
		}else if(data == "false"){
			$('#email ~ .mdl-textfield__error').empty();
			error = '';
			result = true;
		}
		if(type == 1){

			if(CompleteValidation(name, error, pass, passconfirm)){
				result = true;
				if(passconfirm){
					/*console.log('TRUE');*/
					/*Regist();*/
				}else{
					/*$('#regs .regist').on('click', function() {
						$(this).closest('.mdl-textfield').find('#passwd').text('ERROR');
					});*/
					$('label[for="confirmps"]').stop(true,true).animate({
						"color": "#fff",
						"font-weight": "bold",
						"background-color": "#f00",
						"border-radius": "5px"
					},500)
					.delay(300)
					.animate({
						"color": "#000",
						"font-weight": "normal",
						"background-color": "#fff"
					},500);
				}
			}else{
				console.log('FALSE');
				result = false;
			}
		}
		return result;
	});
}

/** Валидация подтверждения пароля **/
function ValidatePassConfirm(passwd, passconfirm){
	if(passconfirm !== passwd || !passconfirm){
		/*console.log('Error');*/
		$('#passwdconfirm + .mdl-textfield__error').empty();
		$('#passwdconfirm').closest('.mdl-textfield ').addClass('is-invalid');
		$('#passwdconfirm + .mdl-textfield__error').append('Пароли не совпадают');
	}else{
		console.log('Пароли совпали');
		$('#passwdconfirm ~ .mdl-textfield__error').empty();
		return false;
	}
}

/** Валидация имени **/
function ValidateName(name){
	if(name.length < 3){
		$('#name ~ .mdl-textfield__error').empty();
		$('#name').closest('.mdl-textfield ').addClass('is-invalid');
		if(name.length == 0){
			$('#name ~ .mdl-textfield__error').append('Введите имя');
		}else{
			$('#name ~ .mdl-textfield__error').append('Имя слишком короткое');
		}
	}else{
		$('#name ~ .mdl-textfield__error').empty();
		return false;
	}
}

/** Завершить валидацию после проверки email */
function CompleteValidation(name, email, passwd, passconfirm){
	var fin = 0,
		res = false;
	if(res = ValidateName(name)){
		$('#regs .mdl-textfield__error').closest('#name .mdl-textfield').text(res);
		fin++;
	}
	if(email){
		$('#regs .mdl-textfield__error').closest('#email .mdl-textfield').text(email);
		fin++;
	}
	if(res = ValidatePass(passwd)){
		/*console.log(passwd);*/
		$('#regs .mdl-textfield__error').closest('#passwd .mdl-textfield').text(res);
		fin++;
	}
	if(res = ValidatePassConfirm(passwd, passconfirm)){
		/*console.log(passconfirm);*/
		$('#regs .mdl-textfield__error').closest('#passwdconfirm .mdl-textfield').text(res);
		fin++;
	}
	if(fin > 0){
		return false;
	}
	return true;
}

function showModals() {
	var modals = $('div:not(.modals) [data-type="modal"]');
	modals.each(function(key, value){
		$(".modals").append(value);
	});
}