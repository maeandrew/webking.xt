//addLoadAnimation('#cart');

// Определение местоположения устройства из которого был осуществлен вход на сайт
function GetLocation() {
	var loc;
	navigator.geolocation.getCurrentPosition(function(position){
		var geocoder = new google.maps.Geocoder,
			latlng = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};

		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				if (results[2]) {
					$('.mainUserInf .userlocation').html(results[2].formatted_address);
				} else {
					$('.mainUserInf .userlocation').html(results[6].formatted_address);
				}
			} else {
				$('.mainUserInf .userlocation').addClass('hidden');
			}
		});
	});
	return loc;
}

// Получение корзины
function GetCartAjax(){
	$('#cart > .modal_container').html('');
	ajax('cart', 'GetCartPage', false, 'html').done(function(data){
		$('#cart > .modal_container').html(data);
		removeLoadAnimation('#cart');
		Position($('#cart'));
	});
}

// Получение опроса
function GetQuizAjax(params){
	var step = params.step === undefined?1:params.step;
	data = {step: step};
	// $('#quiz > .modal_container').html('');
	ajax('quiz', 'step', data, 'html').done(function(data){		
		$('#quiz').html(data);
		componentHandler.upgradeDom();
		removeLoadAnimation('#quiz');
		Position($('#quiz'));
	});
}

// Получение списка товаров в кабинете
function GetCabProdAjax(id_order, rewrite){
	$('.content').addClass('loading');
	ajax('cabinet', 'GetProdList', {'id_order': id_order, 'rewrite': rewrite}, 'html').done(function(data){
		$('.mdl-tabs__panel > #products').html(data);
		$('.content').removeClass('loading');
	});
}

// Получение списка товаров по каждомк заказу в кабинете совместныйх покупок

function GetCabCoopProdAjax(id_cart, rewrite){
	ajax('cabinet', 'GetProdListForJO', {'id_cart': id_cart, 'rewrite': rewrite}, 'html').done(function(data){
		if($('a[href^="#items_panel_"]').hasClass('getCabCoopProdAjax_js')){
			$('.products_cart_js').html(data);
		}else{
			$('.active_link_to_cart_js').closest('li').find('.products_cart_js').html(data);
			$('.list_in_cart_js').removeClass('active_link_to_cart_js');
		}
	});
}

function UserRating(obj){
	var id_user = $('.manager').data('id');
	var bool = 0;
	if(obj.is('.like')){
		bool = 1;
	}
	ajax('cabinet', 'GetRating', {'id_user': id_user,'bool': bool}).done(function(data){
		if(data === 0){
			openObject('modal_message');
		}
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
		.style("height", (h) + "px");

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

		// var raw = new Array();
		var raw = raw_data;

		data = raw.map(function(d){
			for(var k in d){
				console.log(k,d);
				if (!_.isNaN(raw_data[0][k] - 0) && k != 'id'){
					d[k] = parseFloat(d[k]) || 0;
					console.log(d[k]);
					console.log(parseFloat(d[k]));
				}
			}
			return d;
		});

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
			if(dragging[d] < 12 || dragging[d] > w-12){
			d3.select(this).select(".background").style("fill", "#b00");
			} else {
			d3.select(this).select(".background").style("fill", null);
			}
		})
		.on("dragend", function(d) {
			var extent = null;
			if (!this.__dragged__) {
				// no movement, invert axis
				extent = invert_axis(d);
			}else{
				// reorder axes
				d3.select(this).transition().attr("transform", "translate(" + xscale(d) + ")");
				extent = yscale[d].brush.extent();
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
		}));

		// Add an axis and title.
		g.append("svg:g")
			.attr("class", "axis")
			.attr("transform", "translate(0,0)")
			.each(function(d) { d3.select(this).call(axis.scale(yscale[d])); })
		.append("svg:text")
			.attr("text-anchor", "middle")
			.attr("y", function(d, i){ return i%2 === 0 ? -14 : -30; })
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
			d[i] = d[i+1] = d[i+2] = v;
		}
		return pixels;
	}

	function create_legend(colors,brush) {
		// create legend
		var legend_data = d3.select("#legend")
		.html("")
		.selectAll(".row")
		.data( _.keys(colors).sort() );

		// filter by group
		var legend = legend_data
		.enter().append("div")
			.attr("title", "Hide group")
			.on("click", function(d) {
			// toggle food group
			if (_.contains(excluded_groups, d)) {
				d3.select(this).attr("title", "Hide group");
				excluded_groups = _.difference(excluded_groups,[d]);
				brush();
			} else {
				d3.select(this).attr("title", "Show group");
				excluded_groups.push(d);
				brush();
			}
			});

		legend
		.append("span")
		.style("background", function(d,i) { return color(d,0.85); })
		.attr("class", "color-bar");

		legend
		.append("span")
		.attr("class", "tally")
		.text(function(d,i) { return 0;});

		legend
		.append("span")
		.text(function(d,i) { return " " + d;});

		return legend;
	}

	// render polylines i to i+render_speed
	function render_range(selection, i, max, opacity) {
		selection.slice(i,max).forEach(function(d) {
		path(d, foreground, color(d.group,opacity));
		});
	}

	// simple data table
	function data_table(data) {
		// sort by first column
		var sample = data.sort(function(a,b) {
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
			.style("background", function(d) { return color(d.group,0.85); });

		table
		.append("span")
			.text(function(d) { return d.name; });
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
		d3.selectAll(".row").style("opacity", function(p) { return (d.group == p) ? null : "0.3"; });
		path(d, highlighted, color(d.group,1));
	}

	// Remove highlight
	function unhighlight() {
		d3.select("#foreground").style("opacity", null);
		d3.selectAll(".row").style("opacity", null);
		highlighted.clearRect(0,0,w,h);
	}

	function invert_axis(d) {
		var extent = null;
		// save extent before inverting
		if (!yscale[d].brush.empty()) {
			extent = yscale[d].brush.extent();
		}
		if (yscale[d].inverted === true) {
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
	}

	function color(d,a) {
		var c = colors[d];
		//return ["hsla(",c[0],",",c[1],"%,",c[2],"%,",a,")"].join("");
		return ["hsl(120,100%,25%)"].join("");
	}

	function position(d) {
		var v = dragging[d];
		return v === null ? xscale(d) : v;
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
				return extent[0] <= value && value <= extent[1] ? null : "none";
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
		}

		// total by food group
		var tallies = _(selected)
		.groupBy(function(d) { return d.group; });

		// include empty groups
		_(colors).each(function(v,k) { tallies[k] = tallies[k] || []; });

		legend
		.style("text-decoration", function(d) { return _.contains(excluded_groups,d) ? "line-through" : null; })
		.attr("class", function(d) {
			return (tallies[d].length > 0) ? "row" : "row off";
		});

		legend.selectAll(".color-bar")
		.style("width", function(d) {
			return Math.ceil(600*tallies[d].length/data.length) + "px";
		});

		legend.selectAll(".tally")
		.text(function(d,i) { return tallies[d].length; });

		// Render selected lines
		paths(selected, foreground, brush_count, true);
	}

	// render a set of polylines on a canvas
	function paths(selected, ctx, count) {
		var n = selected.length,
			i = 0,
			opacity = d3.min([2/Math.pow(n,0.3),1]),
			timer = (new Date()).getTime();

		selection_stats(opacity, n, data.length);

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
		}

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
			.each(function(d) { d3.select(this).call(yscale[d].brush = d3.svg.brush().y(yscale[d]).on("brush", brush)); });
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
		return keys.map(function(k) { return row[k]; });
		});
		var csv = d3.csv.format([keys].concat(rows)).replace(/\n/g,"<br/>\n");
		var styles = "<style>body { font-family: sans-serif; font-size: 12px; }</style>";
		window.open("text/csv").document.write(styles + csv);
	}

	// scale to window size
	window.onresize = function() {
		width = 900;
		height = 260;

		w = width;
		h = height;

		d3.select("#chart")
			.style("height", (h) + "px");

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
		.attr("transform", function(d) { return "translate(" + xscale(d) + ")"; });
		// update brush placement
		d3.selectAll(".brush")
		.each(function(d) { d3.select(this).call(yscale[d].brush = d3.svg.brush().y(yscale[d]).on("brush", brush)); });
		brush_count++;

		// update axis placement
		axis = axis.ticks(1+height/50);
		d3.selectAll(".axis")
		.each( function(d){ d3.select(this).call(axis.scale(yscale[d])); });

		// render data
		brush();
	};

	// Remove all but selected from the dataset
	function keep_data() {
		new_data = actives();
		if (new_data.length === 0) {
		alert("I don't mean to be rude, but I can't let you remove all the data.\n\nTry removing some brushes to get your data back. Then click 'Keep' when you've selected data you want to look closer at.");
		return false;
		}
		data = new_data;
		rescale();
	}

	// Exclude selected from the dataset
	function exclude_data() {
		new_data = _.difference(data, actives());
		if (new_data.length === 0) {
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
	}

	function show_ticks() {
		d3.selectAll(".axis g").style("display", null);
		//d3.selectAll(".axis path").style("display", null);
		d3.selectAll(".background").style("visibility", null);
		d3.selectAll("#show-ticks").attr("disabled", "disabled");
		d3.selectAll("#hide-ticks").attr("disabled", null);
	}

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
		pattern = new RegExp(str,"i");
		return _(selection).filter(function(d) { return pattern.exec(d.name); });
	}

}

function ModalGraph(id_graphics, moderation){
	ajax('product', 'OpenModalGraph').done(function(data){
		$('#demand_chart .modal_container').html(data);
		componentHandler.upgradeDom();

		if(id_graphics){
			//console.log(id_graphics);
				//$('a').on('click', function(){
				//var id_graphics = $(this).attr('id');
				ajax('product', 'SearchGraph', {'id_graphics': id_graphics}, 'html').done(function(data){
					if(data !== null){
						//console.log(data);
						$('#demand_chart .modal_container').html(data);
						//foo(d3.selectAll("div").text('some text'));

						componentHandler.upgradeDom();
						openObject('demand_chart');
						$('#demand_chart #user_bt').find('a').addClass('update');
						$('#demand_chart').on('click', '.update', function(){
							var parent =  $(this).closest('#demand_chart'),
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
				}).fail(function(data){
					console.log('fail');
				});

		}else{
			openObject('demand_chart');
			$('#demand_chart').on('click', '.btn_js.save', function(){
				var parent =  $(this).closest('#demand_chart'),
					id_category = parent.data('target'),
					is_opt = 0,
					name_user = parent.find('#name_user').val(),
					text = parent.find('textarea').val(),
					arr = parent.find('.one input[type="range"]'),
					arr2 = parent.find('.two input[type="range"]'),
					values = {roz:{},opt:{}};

				if ($('.select_go label').is(':checked')) {
					is_opt = 1;
				}
				//if (true) {};
				arr.each(function(index, val){
					values.roz[index] = $(val).val();
				});
				arr2.each(function(index, val){
					values.opt[index] = $(val).val();
				});
				console.log('values');
				console.log(values);

				//console.log(values);
				ajax('product', 'SaveGraph',{
					'values': values,
					'id_category': id_category,
					'name_user': name_user,
					'moderation': moderation,
					'text': text,
					'opt': is_opt
				}).done(function(data){
					if(data === true){
						console.log('Your data has been saved successfully!');
						closeObject('graph');
						location.reload();
					}else{
						console.log('Something goes wrong!');
					}
				}).fail(function(data){
					console.log('fail');
					console.log(data);
				});
			});
		}
	});
}

function ajax(target, action, data, dataType, form_sent){
	if(form_sent){
		data.append('target', target);
		data.append('action', action);
	}else{
		if(typeof(data) == 'object'){
			data.target = target;
			data.action = action;
		}else{
			data = {target: target, action: action};
		}
	}
	dataType = dataType || 'json';
	var ajax = $.ajax({
		url: URL_base+'ajax',
		beforeSend: function(ajax){
			// console.log(ajax_proceed);
			if(ajax_proceed === true){
				// ajax.abort();
			}
			ajax_proceed = true;
		},
		type: 'POST',
		dataType: dataType,
		data: data,
		processData: form_sent?false:true,
		contentType: form_sent?false:'application/x-www-form-urlencoded; charset=UTF-8'
	}).always(function(){
		ajax_proceed = false;
	});
	// console.log(ajax_proceed);
	return ajax;
}
// Change sidebar aside height
function resizeAsideScroll(event) {	
	var header_height = 52;
	var viewPort = $(window).height(); // высота окна	
	var newMainWindow = $('.main').height();	
	var scroll = $(this).scrollTop(),
		pieceOfFooter = (scroll + viewPort) - newMainWindow - header_height;
	if (pieceOfFooter >= 0) {
		$('aside').css('bottom', (pieceOfFooter > 0?pieceOfFooter:0));
	}
	$('aside').css('max-height', 'calc(100vh - 52px - '+(pieceOfFooter > 0?pieceOfFooter:0)+'px)');
	if(event == 'load' || event == 'click'){
		changeFiltersBtnsPosition();
	}else if(event == 'show_more'){
		$('aside').css('bottom', 'auto');
	}
	return true;
}

// Change product view
function ChangeView(view){
	switch (view) {
		case 'list':
			$('#view_block_js').removeClass().addClass('list_view col-md-12 ajax_loading');
			break;
		case 'block':
			$('#view_block_js').removeClass().addClass('block_view col-md-12 ajax_loading');
			break;
		case 'column':
			$('#view_block_js').removeClass().addClass('column_view col-md-12 ajax_loading');
			break;
	}
	ListenPhotoHover();
	document.cookie="product_view="+view+"; path=/";
}

// Previw Sliders
function ListenPhotoHover(){
	preview = $('.list_view .preview');
	previewOwl = preview.find('#owl-product_slide_js');
	$('.list_view .product_photo:not(hovered)').on('mouseover', function(){
		if($(this).not('.hovered')){
			showPreview(false);
			$(this).addClass('hovered');
			rebuildPreview($(this));
		}
	}).on('mouseleave', function(e){
		if($('#view_block_js').hasClass('list_view')){
			var mp = mousePos(e),
				obj = $(this);
			if(obj.hasClass('hovered') && (mp.x <= obj.offset().left || mp.x >= obj.offset().left+obj.width() || mp.y <= obj.offset().top || mp.y >= obj.offset().top+obj.height())){
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
			if(obj.hasClass('hovered') && (mp.x <= obj.offset().left || mp.x >= obj.offset().left+obj.width() || mp.y <= obj.offset().top || mp.y >= obj.offset().top+obj.height())){
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
		id_product = obj.closest('.card').data('idproduct'),
		// Calculating position of preview window
		viewportWidth = $(window).width(),
		viewportHeight = $(window).height(),
		pos = getScrollWindow(),
		correctionBottom = 0,
		correctionTop = 0,
		marginBottom = 15,
		marginTop = marginBottom+$('header').outerHeight();
	var ovftop = position.top - preview.height()/2 + obj.outerHeight()/2 - marginTop,
		ovfbotton = position.top + preview.height()/2 + obj.outerHeight()/2 + marginBottom;
	if(pos + viewportHeight < ovfbotton){
		// console.log('overflow Bottom');
		correctionBottom = ovfbotton - (pos + viewportHeight);
	}else if(pos > ovftop){
		// console.log('overflow Top');
		correctionTop = ovftop - pos;
	}
	preview.css({
		top: position.top - positionProd.top - preview.height()/2 + obj.height()/2 - correctionBottom - correctionTop,
		left: 80,
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
		ajax('product', 'GetPreview', {'id_product': id_product}, 'html').done(function(data){
			preview.find('.preview_content').html(data);
			componentHandler.upgradeDom();
			showPreview(true);
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
		if(totop.hasClass('visible') === false){
			totop.addClass('visible');
		}
	}else{
		if(totop.hasClass('visible')){
			totop.removeClass('visible');
		}
	}
}

function showPreview(ajax){
	if(ajax){
		preview.removeClass('ajax_loading').find('#owl-product_slide_js').owlCarousel({
			center:			true,
			dots:			true,
			items:			1,
			margin:			20,
			nav:			true,
			video:			true,
			videoHeight:	300,
			videoWidth:		300,
			navText: [
				'<svg class="arrow_left"><use xlink:href="images/slider_arrows.svg#arrow_left_tidy"></use></svg>',
				'<svg class="arrow_right"><use xlink:href="images/slider_arrows.svg#arrow_right_tidy"></use></svg>'
			]
		});
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
function ChangePriceRange(column, manual){
	var a = false;
	if (column != $.cookie('sum_range')){
		a = true;
	}

	if (manual == 1){
		$.cookie('sum_range', column, { path: '/'});
		$.cookie('manual', 1, { path: '/'});
		$('li.sum_range').removeClass('active');
		$('li.sum_range_'+column).addClass('active');
	}else if ($.cookie('manual') != 1){
		$.cookie('sum_range', column, { path: '/'});
		$('li.sum_range').removeClass('active');
		$('li.sum_range_'+column).addClass('active');
		if(column > 0){
			column = column - 1;
		}else{
			column = 0;
		}
	}else{
		column = $.cookie('sum_range');
	}	

	var text = '';
	addLoadAnimation('.order_balance');
	ajax('cart', 'GetCart').done(function(data){
		removeLoadAnimation('.order_balance');
		currentSum = data.products_sum[3];
		newSum = columnLimits[column] - currentSum;
		if (newSum < 0){
			text = 'Заказано достаточно!';
		}else{
			if ($.cookie('manual') == 1 ){
				text = 'Дозаказать еще на '+newSum.toFixed(2).toString().replace('.',',')+' грн.';				
			}else{
				text = 'До следующей скидки '+newSum.toFixed(2).toString().replace('.',',')+' грн.';	
			}
		}
		$('.order_balance').text(text);

		$('.product_buy').each(function(){ // отображение оптовой или малооптовой (розничной) цены товара в каталоге
			var minQty = parseInt($(this).find('.minQty').val());
			var curentQty =	parseInt($(this).find('.qty_js').val());
			var price = parseFloat($(this).find('.price'+ (curentQty >= minQty?'Opt':'Mopt') +$.cookie('sum_range')).val()).toFixed(2).toString().replace('.',',');
			if(curentQty >= minQty){
				$(this).find('.priceMoptInf').addClass('hidden');
			}else{
				$(this).find('.priceMoptInf').removeClass('hidden');
			}
			$(this).find('.price').html(price);
		});

		// Подсветка цен товаров для привлечения внимания
		if(a === true){
			setTimeout(function(){
				$('.product_buy .product_price *').stop(true,true).css({
					color: '#FF5722'
				}).delay(1000).animate({
					color: '#444444'
				}, 3000);

			},300);
		}
	});
}

function openObject(id, params){
	switch(id){
		case 'cart':
			GetCartAjax(params);
			break;
		case 'quiz':
			GetQuizAjax({reload: false, step: 3});
			break;
	}
	if(params === undefined || params.reload !== true){
		var object = $('#'+id),
			type = object.data('type');
		if($('html').hasClass('active_bg')){
			$('.opened:not([id="'+object.attr('id')+'"])').each(function(index, el) {
				closeObject($(this).attr('id'));
			});
		}
		if(object.hasClass('opened') && type != "search"){
			closeObject(object.attr('id'));
			DeactivateBG();
		}else{
			if(id=="cart"){
				addLoadAnimation('#'+id);
			}
			if(id == 'phone_menu'){
				$('[data-name="phone_menu"] i').text('close');
			}
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
	}
}

function closeObject(id){
	if(id === undefined){
		$('.opened').each(function(index, el) {
			closeObject($(this).attr('id'));
		});
	}else{
		$('#'+id).removeClass('opened');
		if(id == 'phone_menu'){
			$('[data-name="phone_menu"] i').text('menu');
		}
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
	$('html').addClass('active_bg');
}
//Деактивация подложки
function DeactivateBG(){
	$('html').removeClass('active_bg');
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
function ValidatePass(passwd, el){
	var protect = 0,
		result,
		parent = el.closest('.forPassStrengthContainer_js');
	
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
		parent.find('.ps_lvl_js').addClass('bad').removeClass('better').removeClass('ok').removeClass('best');
		result = false;
	}
	if(protect == 2) {
		parent.find('.ps_lvl_js').addClass('better').removeClass('ok').removeClass('best');;
		result = false;
	}
	if(protect == 3) {
		parent.find('.ps_lvl_js').addClass('ok').removeClass('best');
		result = false;
	}
	if(protect == 4) {
		parent.find('.ps_lvl_js').addClass('best');
		result = false;
	}
	if(passwd.length < 1){
		$('#passwd + .mdl-textfield__error').empty();
		parent.find('.ps_lvl_js').removeClass('bad').removeClass('better').removeClass('ok').removeClass('best');
		$('[name="new_passwd"], [name="passwd"]').closest('.mdl-textfield').find('.mdl-textfield__error').text('Введите пароль');
	}else if(passwd.length >= 1 && passwd.length < 4) {
		$('#passwd + .mdl-textfield__error').empty();
		$('[name="new_passwd"], [name="passwd"]').closest('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').text('Пароль слишком короткий');
	}
	return result;
}

/** Валидация подтверждения пароля **/
function ValidatePassConfirm(passwd, passconfirm){
	if(passconfirm !== passwd || !passconfirm){
		$('[name="passwdconfirm"]').closest('.mdl-textfield').addClass('is-invalid').find('.mdl-textfield__error').text('Пароли не совпадают').css({'visibility': 'visible', 'color': '#D50000'});
		$('.verification_btn').attr('disabled', 'disabled');
	}else{
		$('[name="passwdconfirm"]').closest('.mdl-textfield').removeClass('is-invalid').find('.mdl-textfield__error').text('Пароли совпали').css({'visibility': 'visible', 'color': '#018b06'});
		if($('[name="passwdconfirm"]').val().length >= 4) $('.verification_btn').removeAttr('disabled');
		return false;
	}
}

var req = null;
/** Валидация email **/
function ValidateEmail(fields, type){
	ajax('auth', 'register', fields).done(function(data){
		removeLoadAnimation('#registration');
		return data;
	});
}

/** Валидация имени **/
function ValidateName(name){
	if(name.length < 3){
		$('#name ~ .mdl-textfield__error').empty();
		$('#name').closest('.mdl-textfield ').addClass('is-invalid');
		if(name.length === 0){
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

function moveObjects() {
	var modals = $('div:not(.modals) [data-type="modal"]');
	modals.each(function(key, value){
		$(".modals").append(value);
	});
	var panels = $('div:not(.panels) [data-type="panel"]');
	panels.each(function(key, value){
		$(".panels").append(value);
	});
}
// Удаление товара из ассортимента поставщика в кабинете
function DelFromAssort(id){
	ajax('product', 'DelFromAssort', {id_product: id}).done(function(){
		$('#tr_mopt_'+id).slideUp();
	});
}
// Добавление или обновление товара в ассортименте
function toAssort(id, opt, nacen, comment){
	var inusd = $('.inusd'+id).prop('checked');
	var currency_rate = $('#currency_rate').val();
	if(opt == 1){
		mode = "opt";
	}else{
		mode = "mopt";
	}
	var a,b,c;
	a = parseFloat($("#price_"+mode+"_otpusk_"+id).val().replace(",","."));
	b = parseFloat($("#price_"+mode+"_otpusk_"+id).val().replace(",","."));
	if(inusd === true){
		a = a*currency_rate;
		b = b*currency_rate;
	}
	c = parseFloat($("#product_limit_mopt_"+id).val());
	$("#product_limit_mopt_"+id).val(c);
	active = 0;
	if(c > 0){
		if(opt){
			po = parseFloat($("#price_opt_"+id).val());
			pom = Number(po - po*parseFloat($("#price_delta_otpusk").val())*0.01).toFixed(2);
			if(po !== 0 && a > pom){
				alert("Предлагаемая Вами крупнооптовая цена не позволяет продавать данный товар на сайте.");
			}
			pop = Number(po + po*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			pom = Number(po - po*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			if(po !== 0 && (b > pop || b < pom)){
				alert("Предлагаемая Вами среднерыночная цена значительно отличается от цены сайта (более "+parseFloat($("#price_delta_recom").val())+"%).");
			}
		}else{
			pm = parseFloat($("#price_mopt_"+id).val());
			pmm = Number(pm - pm*parseFloat($("#price_delta_otpusk").val())*0.01).toFixed(2);
			if(pm !== 0 && a > pmm){
				alert("Предлагаемая Вами мелкооптовая цена не позволяет продавать данный товар на сайте.");
			}
			pmp = Number(pm + pm*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			pmm = Number(pm - pm*parseFloat($("#price_delta_recom").val())*0.01).toFixed(2);
			if(pm !== 0 && (b > pmp || b < pmm)){
				alert("Предлагаемая Вами среднерыночная цена значительно отличается от цены сайта (более "+parseFloat($("#price_delta_recom").val())+"%).");
			}
		}
		ao = parseFloat($("#price_opt_otpusk_"+id).val());
		bo = parseFloat($("#price_opt_otpusk_"+id).val());
		am = parseFloat($("#price_mopt_otpusk_"+id).val());
		bm = parseFloat($("#price_mopt_otpusk_"+id).val());
		active = 1;
		if((ao > 0 && bo === 0) || (ao === 0 && bo > 0)){
			active = 0;
			alert("Необходимо заполнить цены.");
		}else if((am > 0 && bm === 0) || (am === 0 && bm > 0)){
			active = 0;
			alert("Необходимо заполнить цены.");
		}
	}
	if(active == 1){
		$("#tr_opt_"+id).removeClass('notavailable notprice').addClass('available');
		$("#tr_mopt_"+id).removeClass('notavailable notprice').addClass('available');
	}else{
		$("#tr_opt_"+id).removeClass('available').addClass('notavailable');
		$("#tr_mopt_"+id).removeClass('available').addClass('notavailable');
		$("#product_limit_opt_"+id).val(0);
		$("#product_limit_mopt_"+id).val(0);
	}
	if(a <= 0 || b <= 0){
		//$("#checkbox_"+mode+"_"+id).attr('checked','');
		$("#tr_opt_"+id).removeClass('available').addClass('notavailable notprice');
		$("#tr_mopt_"+id).removeClass('available').addClass('notavailable notprice');
	}
	if(a < 0){
		a = 0;
		$("#price_opt_otpusk_"+id).val(a);
	}
	//if (b<0){ b=0;$("#price_opt_recommend_"+id).val(b);}
	$.ajax({
		url: URL_base+'ajaxassort',
		type: "POST",
		cache: false,
		dataType: "json",
		data:{
			"action": "update_assort",
			"opt": opt,
			"id_product": id,
			"price_otpusk": a,
			"price_recommend": b,
			"nacen": nacen,
			"product_limit": c,
			"active": active,
			"sup_comment": comment,
			"inusd": inusd,
			"currency_rate": currency_rate
		}
	});
}

/*Добавить/Удалить товар а ассортименте у конкретного поставщика*/
function AddDelProductAssortiment(obj, id){
	if (obj.checked){
		action = "AddToAssort";
	}else{
		action = "DelFromAssort";
	}
	
	ajax('product', action, {id_product:id});

	// $.ajax({
	// 	url: URL_base+'ajaxassort',
	// 	type: "POST",
	// 	cache: false,
	// 	dataType: "json",
	// 	data: {
	// 		"action":action,
	// 		"id_product":id
	// 	},
	// });
}

// Установить куки
function setCookie(name, value) {
	var valueEscaped = escape(value);
	var expiresDate = new Date();
	expiresDate.setTime(expiresDate.getTime() + 365 * 24 * 60 * 60 * 1000); // срок - 1 год
	var expires = expiresDate.toGMTString();
	var newCookie = name + "=" + valueEscaped + "; path=/; expires=" + expires;
	if (valueEscaped.length <= 4000) document.cookie = newCookie + ";";
}

// Получить куки
function getCookie(name) {
	var prefix = name + "=";
	var cookieStartIndex = document.cookie.indexOf(prefix);
	if (cookieStartIndex == -1) return null;
	var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length);
	if (cookieEndIndex == -1) cookieEndIndex = document.cookie.length;
	return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex));
}


// Анимация ожидания отклика от сервера

function addLoadAnimation(obj) {
	/*console.log($(obj).find("div.loadBlock").length > 0);*/
	if($(obj).find("div.loadBlock").length <= 0){
		$(obj).append('<div class="loadBlock"><div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active loadAnimation"></div></div>');
	}
	componentHandler.upgradeDom();
}

function removeLoadAnimation(obj) {
	/*console.log($(obj).find("div.loadBlock").length > 0);*/
	if($(obj).find("div.loadBlock").length > 0){
		$(obj).find("div.loadBlock").remove();
	}
	// componentHandler.upgradeDom();
}

//Добавление товара в избранное
function AddFavorite(id_product, targetEl){
	ajax('product', 'add_favorite', {id_product: id_product}).done(function(data){
		if(data.answer == 'login'){
			openObject('auth');
			removeLoadAnimation('#auth');
		}else if(data.answer == 'already'){
			var data = {message: 'Товар уже находится в избранном'};
		}else{
			if(data.answer == 'ok'){
				$('.userChoiceFav').text('('+data.fav_count+')');
				var data = {message: 'Товар добавлен в избранное'};
				targetEl.empty().text('favorite').removeClass('notfavorite').addClass('isfavorite');
				targetEl.next().empty().text('Товар уже в избранном');
			}else{
				if(data.answer == 'wrong user group'){
					var data = {message: 'Данный функционал доступен только для клиентов'};
				}
			}
		}
		var snackbarContainer = document.querySelector('#demo-toast-example');
		snackbarContainer.MaterialSnackbar.showSnackbar(data);
	}).fail(function(data){
		alert("Error");
	});
	return false;
}
//Удаление товара из избранных
function RemoveFavorite(id_product, targetEl){
	ajax('product', 'del_favorite', {id_product: id_product}).done(function(data){
		if(data.answer == 'login'){
			openObject('auth');
			removeLoadAnimation('#auth');
		}else{
			if(data.answer == 'ok'){
				$('.userChoiceFav').text('('+data.fav_count+')');
				var data = {message: 'Товар удален из избранного'};
				targetEl.empty().text('favorite_border').addClass('notfavorite').removeClass('isfavorite');
				targetEl.next().empty().text('Добавить товар в избранное');
			}else{
				if(data.answer == 'wrong user group'){
					var data = {message: 'Данный функционал доступен только для клиентов'};
				}
			}
		}
		var snackbarContainer = document.querySelector('#demo-toast-example');
		snackbarContainer.MaterialSnackbar.showSnackbar(data);
	}).fail(function(data){
		alert("Error");
	});
	return false;

	//Удаление товара из избранных (старая версия)
		// var id_product = targetEl.closest('.favorite_js').attr('data-idproduct');
		// if (confirm('Вы точно хотите удалить товар из списка избранных?')) {
		// 	$.ajax({
		// 		url: URL_base+'ajax_customer',
		// 		type: "POST",
		// 		cache: false,
		// 		dataType: "json",
		// 		data: {
		// 			"action":'del_favorite',
		// 			"id_product": id_product
		// 		}
		// 	}).done(function(){
		// 		location.reload();
		// 	});
		// };
}

//Добавление товара в список ожидания
function AddInWaitingList(id_product, id_user, email, targetClass){
	var data = {
		id_product: id_product,
		id_user: id_user,
		email: email
	};
	ajax('product', 'add_in_waitinglist', data).done(function(data){
		if(data.answer == 'login'){
			openObject('auth');
			removeLoadAnimation('#auth');
		}else if(data.answer == 'already'){
			var data = {message: 'Товар уже в списке ожидания'};
		}else{
			if(data.answer == 'ok'){
				$('.userChoiceWait').text('('+data.fav_count+')');
				var data = {message: 'Товар добавлен в список ожидания'};
				targetClass.addClass('arrow');
				targetClass.closest('li').next().empty().text('Товар в списке ожидания');
			}else{
				if(data.answer == 'wrong user group'){
					var data = {message: 'Данный функционал доступен только для клиентов'};
				}
			}
		}
		var snackbarContainer = document.querySelector('#demo-toast-example');
		snackbarContainer.MaterialSnackbar.showSnackbar(data);
	}).fail(function(data){
		var data = {message: 'Данный функционал доступен только для клиентов'};
		var snackbarContainer = document.querySelector('#demo-toast-example');
		snackbarContainer.MaterialSnackbar.showSnackbar(data);
	});
	return false;
}
//Удаление товара из списка ожидания
function RemoveFromWaitingList(id_product, id_user, email, targetClass){
	var data = {
		id_product: id_product,
		id_user: id_user,
		email: email
	};
	ajax('product', 'del_from_waitinglist', data).done(function(data){
		if(data.answer == 'login'){
			openObject('auth');
			removeLoadAnimation('#auth');
		}else{
			if(data.answer == 'ok'){
				$('.userChoiceWait').text('('+data.fav_count+')');
				var data = {message: 'Товар удален из списка ожидания'};
				targetClass.removeClass('arrow');
				targetClass.closest('li').next().empty().text('Следить за ценой');
			}else{
				if(data.answer == 'wrong user group'){
					var data = {message: 'Данный функционал доступен только для клиентов'};
				}
			}
		}
		var snackbarContainer = document.querySelector('#demo-toast-example');
		snackbarContainer.MaterialSnackbar.showSnackbar(data);
	}).fail(function(data){
		var data = {message: 'Данный функционал доступен только для клиентов'};
		var snackbarContainer = document.querySelector('#demo-toast-example');
		snackbarContainer.MaterialSnackbar.showSnackbar(data);
	});
	return false;
}

function changeFiltersBtnsPosition(){
	if($('.filters').length > 0){
		if($('.filters').offset().top-$(window).scrollTop() <= 50){
			$('#filterButtons').addClass('buttonsTop');
			/*$('.filters').css('padding-top', $('#filterButtons').height());*/
			$('#clear_filter, #applyFilter').css('margin-top', '7px');
		}else{
			$('.filters').css('padding-top', 0);
			$('#filterButtons').removeClass('buttonsTop');
			$('#clear_filter, #applyFilter').css('margin-top', '');
		}
	}
}


function segmentOpen(id){
	console.log('123');
	$('[data-id="'+id+'"]').each(function(){
		var list = $(this).find('ul');
		if(list.length > 0){
			console.log('есть');
		}else{
			console.log('нету');
			addLoadAnimation('.catalog');
			ajax('segment', 'segmid', {idsegment: id}, 'html').done(function(data){
				removeLoadAnimation('.catalog');
				$('.second_nav li').removeClass('active');
				$('[data-id="'+id+'"]').append(data);
				$('[data-id="'+id+'"]').find('.link_wrapp').find('span').addClass('more_cat');
				var lvl = $('[data-id="'+id+'"]').find('ul').data('lvl');
				var parent = $('[data-id="'+id+'"]');
				var parent_active = parent.hasClass('active');
				$('[data-id="'+id+'"]').find('ul').find('li').removeClass('active').find('ul').stop(true, true).slideUp();
				if(!parent_active){
					parent.addClass('active').find('> ul').stop(true, true).slideDown();
				}
			});
		}
	});
}

function regionSelect(obj){
	var parent = obj.closest('form'),
		region = obj.val();
	addLoadAnimation(parent);
	if(region !== undefined){
		ajax('location', 'regionSelect', {region: region}, 'html').done(function(data){
			removeLoadAnimation(parent);
			parent.find('select:not(#region) option').remove();
			parent.find('#city').html(data).prop('disabled', false);
			parent.find('#delivery_service, #insurance, #delivery_department').closest('div.mdl-cell').addClass('hidden');
			// citySelect(parent.find('#city'));
		});
	}
}

function citySelect(obj){
	var parent = obj.closest('form'),
		city = obj.val(),
		region = parent.find('#region').val();
	addLoadAnimation(parent);
	if(city !== undefined && region !== undefined){
		ajax('location', 'citySelect', {city: city, region: region}, 'html').done(function(data){
			removeLoadAnimation(parent);
			parent.find('select:not(#region, #city) option').remove();
			parent.find('#id_delivery').html(data).prop('disabled', false);
			parent.find('#delivery_service, #insurance, #delivery_department').closest('div.mdl-cell').addClass('hidden');
			// deliverySelect(parent.find('#id_delivery'));
		});
	}
}

function deliverySelect(obj){
	var parent = obj.closest('form'),
		id_delivery = obj.val(),
		city = parent.find('#city').val(),
		region = parent.find('#region').val();
		// console.log(id_delivery);
		// console.log(city);
		// console.log(region);
	addLoadAnimation(parent);
	switch(id_delivery){
		case '1':
			ajax('location', 'deliverySelect', {city: city, region: region}, 'html').done(function(data){
				removeLoadAnimation(parent);
				parent.find('#id_delivery_service option').remove();
				parent.find('#id_delivery_service').html(data).prop('required', true).prop('disabled', false);
				parent.find('.delivery_service').closest('div.mdl-cell').removeClass('hidden');
				parent.find('.address').closest('div.mdl-cell').addClass('hidden');
				// deliveryServiceSelect(parent.find('#id_delivery_service'));
			});
			break;
		default:
			ajax('location', 'getCityId', {city: city}, 'html').done(function(data){
				removeLoadAnimation(parent);
				parent.find('#delivery_service, #insurance, #delivery_department').slideUp();
				parent.find('#delivery_department option').remove();
				parent.find('#delivery_department').append(data);
				parent.find('.content-insurance').slideUp();
				parent.find('.address').closest('div.mdl-cell').removeClass('hidden');
				parent.find('.delivery_service').closest('div.mdl-cell').removeClass('hidden');
				parent.find('.delivery_department').closest('div.mdl-cell').addClass('hidden');
			});
			break;
	}

	// if(value == "3"){
	// 	$.ajax({
	// 		url: URL_base+'ajaxorder',
	// 		type: "POST",
	// 		data:({
	// 			"city": city,
	// 			"action": 'deliverySelect'
	// 		}),
	// 	}).done(function(data){
	// 		$('#id_delivery_service, #id_delivery_department').prop('required',true);
	// 		$('#id_delivery_service option').remove();
	// 		$('#delivery_service, #insurance, #delivery_department').slideDown();
	// 		$('#id_delivery_service').append(data);
	// 		$('.content-insurance').slideDown();
	// 		deliveryServiceSelect($('#id_delivery_service').val());
	// 	});
	// }else if(value == "2"){
	// 	$.ajax({
	// 		url: URL_base+'ajaxorder',
	// 		type: "POST",
	// 		data:({
	// 			"city": city,
	// 			"action":'getCityId'
	// 		}),
	// 	}).done(function(data){
	// 		$('#delivery_service, #insurance, #delivery_department').slideUp();
	// 		$('#id_delivery_department option').remove();
	// 		$('#id_delivery_department').append(data);
	// 		$('.content-insurance').slideUp();
	// 	});
	// }else if(value == "1"){
	// 	$.ajax({
	// 		url: URL_base+'ajaxorder',
	// 		type: "POST",
	// 		data:({
	// 			"city": city,
	// 			"action":'getCityId'
	// 		}),
	// 	}).done(function(data){
	// 		$('#delivery_service, #insurance, #delivery_department').slideUp();
	// 		$('#id_delivery_department option').remove();
	// 		$('#id_delivery_department').append(data);
	// 		$('.content-insurance').slideUp();
	// 	});
	// }
}

function deliveryServiceSelect(obj){
	console.log(obj);
	var parent = obj.closest('form'),
		region = parent.find('#region').val(),
		city = parent.find('#city').val(),
		id_delivery = parent.find('#id_delivery').val(),
		shipping_comp = obj.val(),
		ref = obj.find('option:selected').data('ref');
	addLoadAnimation(parent);
	// console.log('');
	// console.log('Область - '+region);
	// console.log('Город - '+city);
	// console.log('Способ - '+id_delivery);
	// console.log('Служба - '+shipping_comp);
	ajax('location', 'deliveryServiceSelect', {city: city, region: region, shipping_comp: shipping_comp, ref: ref, id_delivery: id_delivery}, 'html').done(function(data){
		removeLoadAnimation(parent);
		parent.find('#delivery_department option').remove();
		parent.find('#delivery_department').html(data).prop({required: true, disabled: false});
		parent.find('.delivery_department').closest('div.mdl-cell').removeClass('hidden');
	});
}

// function checkPhoneNumber(pnoneNumber){
// 	if(pnoneNumber.replace(/[^\d]+/g, "").length == 12){
// 		$('input.phone').data('value', pnoneNumber.replace(/[^\d]+/g, ""));
// 		console.log($('input.phone').data('value'));
// 		$('input.phone').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'hidden');
// 	}else{
// 		console.log("YTN");
// 		$('input.phone').closest('.mdl-textfield').find('.mdl-textfield__error').css('visibility', 'visible');
// 	}
// }

function UpdateProductsList(page, arr){
	ajax('products', 'getmoreproducts', arr, 'html').done(function(data){
		removeLoadAnimation('.products');
		page.find('.products').html(data);
		// var product_view = $.cookie('product_view'),
		// 	show_count = parseInt((count-30)-parseInt(skipped_products+shown_products));
		componentHandler.upgradeDom();
		$("img.lazy").lazyload({
			effect : "fadeIn"
		});		
		ListenPhotoHover();//Инициализания Preview
		resizeAsideScroll('show_more');		
	});
}

function SortProductsList() {
	$('.sorting_js').find('option').each(function(index,el){
		if ($(el).text() == $('.mdl-selectfield__box span').text()) {
			location.href=$(el).val();
		}
	});
}

//-----
// Блок кода для выделения ошибок на канвасе
var canvas, context, canvaso, contexto;
		
// По умолчанию линия - инструмент по умолчанию
var tool;
var tool_default = 'line';

function init(color, tool_type){
	canvaso = document.getElementById('err_canvas');
	if(!canvaso){
		alert('Ошибка! Canvas элемент не найден!');
		return;
	}
	if(!canvaso.getContext){
		alert('Ошибка! canvas.getContext не найден!');
		return;
	}
	contexto = canvaso.getContext('2d');
	if(!contexto){
		alert('Ошибка! Не могу получить getContext!');
		return;
	}

	var container = canvaso.parentNode;
	canvas = document.createElement('canvas');
	if(!canvas){
		alert('Ошибка! Не могу создать canvas элемент!');
		return;
	}

	canvas.id = 'imageTemp';
	canvas.width = canvaso.width;
	canvas.height = canvaso.height;
	container.appendChild(canvas);

	context = canvas.getContext('2d');
	context.strokeStyle = color;

	// Получаем инструмент
	switch (tool_type) {
		case 'rect':
			tool = new tools['rect']();
			break;
		case 'fillrect':
			tool = new tools['fillrect']();
			break;
		case 'pencil':
			tool = new tools['pencil']();
			context.lineWidth = 4;
			break;
		case 'eraser':
			tool = new tools['eraser']();
			context.lineWidth = 20;
			break;
		default:
			break;
	}

	canvas.addEventListener('mousedown', ev_canvas, false);
	canvas.addEventListener('mousemove', ev_canvas, false);
	canvas.addEventListener('mouseup', ev_canvas, false);
}

function ev_canvas(ev){
	// if (ev.layerX || ev.layerX == 0) {
	// 	ev._x = ev.layerX;
	// 	ev._y = ev.layerY;
	// } else if (ev.offsetX || ev.offsetX == 0) {
	// 	ev._x = ev.offsetX;
	// 	ev._y = ev.offsetY;
	// }

	// console.log(ev);
		ev._x = ev.layerX;
		ev._y = ev.layerY;
	// if (ev.layerX || ev.layerX == 0) {
	// } else if (ev.offsetX || ev.offsetX == 0) {
	// 	ev._x = ev.offsetX;
	// 	ev._y = ev.offsetY + $(window).scrollTop();
	// }

	var func = tool[ev.type];
	if (func) {
		func(ev);
	}
}

// Эта функция вызывается каждый раз после того, как пользователь
// завершит рисование. Она очищает imageTemp.
function img_update(){
	contexto.drawImage(canvas, 0, 0);
	context.clearRect(0, 0, canvas.width, canvas.height);
}

function clear_canvas(){
	contexto.clearRect(0, 0, canvaso.width, canvaso.height);
	$('#canvas_mark_wrapper').find('canvas:not(#err_canvas)').remove();
}

// Содержит реализацию каждого инструмента рисования
var tools = {};

// Карандаш
tools.pencil = function(){
	var tool = this;
	this.started = false;

	// Рисуем карандашом
	this.mousedown = function(ev){
		context.beginPath();
		context.moveTo(ev._x, ev._y);
		tool.started = true;
	};
	this.mousemove = function(ev){
		if (tool.started) {
			context.lineTo(ev._x, ev._y);
			context.stroke();
		}
	};
	this.mouseup = function(ev){
		if (tool.started) {
			tool.mousemove(ev);
			tool.started = false;
			img_update();
		}
	};
};

// Прямоугольник
tools.rect = function(){
	var tool = this;
	this.started = false;

	this.mousedown = function(ev){
		tool.started = true;
		tool.x0 = ev._x;
		tool.y0 = ev._y;
	};
	this.mousemove = function(ev){
		if (!tool.started) {
			return;
		}

		var x = Math.min(ev._x,  tool.x0),
		y = Math.min(ev._y,  tool.y0),
		w = Math.abs(ev._x - tool.x0),
		h = Math.abs(ev._y - tool.y0);

		context.clearRect(0, 0, canvas.width, canvas.height);

		if (!w || !h) {
			return;
		}
		context.lineWidth = 3;
		context.strokeRect(x, y, w, h);
	};
	this.mouseup = function(ev){
		if (tool.started) {
			tool.mousemove(ev);
			tool.started = false;
			img_update();
		}
	};
};

// Прямоугольник закрашенный
tools.fillrect = function(){
	var tool = this;
	this.started = false;

	this.mousedown = function(ev){
		tool.started = true;
		tool.x0 = ev._x;
		tool.y0 = ev._y;
	};

	this.mousemove = function(ev){
		if (!tool.started) {
			return;
		}

		var x = Math.min(ev._x,  tool.x0),
		y = Math.min(ev._y,  tool.y0),
		w = Math.abs(ev._x - tool.x0),
		h = Math.abs(ev._y - tool.y0);

		context.clearRect(0, 0, canvas.width, canvas.height);

		if (!w || !h) {
			return;
		}

		context.fillRect(x, y, w, h);
	};

	this.mouseup = function(ev){
		if (tool.started) {
			tool.mousemove(ev);
			tool.started = false;
			img_update();
		}
	};
};

// Линия
tools.line = function(){
	var tool = this;
	this.started = false;

	this.mousedown = function(ev){
		tool.started = true;
		tool.x0 = ev._x;
		tool.y0 = ev._y;
	};

	this.mousemove = function(ev){
		if (!tool.started) {
			return;
		}

		context.clearRect(0, 0, canvas.width, canvas.height);

		context.beginPath();
		context.moveTo(tool.x0, tool.y0);
		context.lineTo(ev._x,   ev._y);
		context.stroke();
		context.closePath();
	};

	this.mouseup = function(ev){
		if (tool.started) {
			tool.mousemove(ev);
			tool.started = false;
			img_update();
		}
	};
};

// Ластик
tools.eraser = function(){
	var tool = this;
	this.started = false;

	this.mousedown = function(ev){
		context.beginPath();
		context.moveTo(ev._x, ev._y);
		tool.started = true;
	};
	this.mousemove = function(ev){
		if (tool.started) {
			context.lineTo(ev._x, ev._y);
			context.stroke();
		}
	};
	this.mouseup = function(ev){
		if (tool.started) {
			tool.mousemove(ev);
			tool.started = false;
			img_update();
		}
	};
};
//-----