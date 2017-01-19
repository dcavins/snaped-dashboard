<?php
/**
 * Generate the public-facing pieces of the plugin.
 *
 * Community Commons MoCWP
 *
 * @package   CARES_SnapEd_Dashboard
 * @author    AuthorName
 * @license   GPL-2.0+
 * @link      http://www.communitycommons.org
 * @copyright 2016 Community Commons
 */

function csed_dashboard( $chart = 'bar_pie_duo' ) {
	if ( 'stacked_bar' == $chart ) {
		?>
		<style>
			.bar {
			  fill: steelblue;
			}
			.axis path {
			  display: none;
			}
		</style>

		<div class="vis-container Grid">
			<div class="Grid-cell">
				<svg width="960" height="500"></svg>
			</div>
		</div>

		<script>
			var svg = d3.select("svg"),
				margin = {top: 20, right: 20, bottom: 30, left: 40},
				width = +svg.attr("width") - margin.left - margin.right,
				height = +svg.attr("height") - margin.top - margin.bottom,
				g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

			var x = d3.scaleBand()
				.rangeRound([0, width])
				.padding(0.1)
				.align(0.1);

			var y = d3.scaleLinear()
				.rangeRound([height, 0]);

			var z = d3.scaleOrdinal()
				.range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

			var stack = d3.stack();

			d3.csv("<?php echo csed_get_plugin_base_uri() . 'public/data-files/stacked-bar.csv' ?>", type, function(error, data) {
			  if (error) throw error;
			  // console.log( 'loaded the csv.' );
			  // console.log( data );
			  data.sort(function(a, b) { return b.total - a.total; });

			  x.domain(data.map(function(d) { return d.State; }));
			  y.domain([0, d3.max(data, function(d) { return d.total; })]).nice();
			  z.domain(data.columns.slice(1));

			  g.selectAll(".serie")
				.data(stack.keys(data.columns.slice(1))(data))
				.enter().append("g")
				  .attr("class", "serie")
				  .attr("fill", function(d) { return z(d.key); })
				.selectAll("rect")
				.data(function(d) { return d; })
				.enter().append("rect")
				  .attr("x", function(d) { return x(d.data.State); })
				  .attr("y", function(d) { return y(d[1]); })
				  .attr("height", function(d) { return y(d[0]) - y(d[1]); })
				  .attr("width", x.bandwidth());

			  g.append("g")
				  .attr("class", "axis axis--x")
				  .attr("transform", "translate(0," + height + ")")
				  .call(d3.axisBottom(x));

			  g.append("g")
				  .attr("class", "axis axis--y")
				  .call(d3.axisLeft(y).ticks(10, "s"))
				.append("text")
				  .attr("x", 2)
				  .attr("y", y(y.ticks(10).pop()))
				  .attr("dy", "0.35em")
				  .attr("text-anchor", "start")
				  .attr("fill", "#000")
				  .text("Population");

			  var legend = g.selectAll(".legend")
				.data(data.columns.slice(1).reverse())
				.enter().append("g")
				  .attr("class", "legend")
				  .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; })
				  .style("font", "10px sans-serif");

			  legend.append("rect")
				  .attr("x", width - 18)
				  .attr("width", 18)
				  .attr("height", 18)
				  .attr("fill", z);

			  legend.append("text")
				  .attr("x", width - 24)
				  .attr("y", 9)
				  .attr("dy", ".35em")
				  .attr("text-anchor", "end")
				  .text(function(d) { return d; });
			});

			function type(d, i, columns) {
			  for (i = 1, t = 0; i < columns.length; ++i) t += d[columns[i]] = +d[columns[i]];
			  d.total = t;
			  return d;
			}

		</script>
		<?php
	} elseif ( 'bar_sample' == $chart ) {
		?>
		<style>
			.bar {
			  fill: steelblue;
			}

			.axis text {
			  font: 10px sans-serif;
			}

			.axis path,
			.axis line {
			  fill: none;
			  stroke: #000;
			  shape-rendering: crispEdges;
			}

			.x.axis path {
			  display: none;
			}
		</style>

		<div class="vis-container Grid">
			<div class="Grid-cell">
				<svg class="chart"></svg>
			</div>
		</div>

		<script>
			var frequency = [
				{ letter:'A', frequency: .08167 },
				{ letter:'B', frequency: .01492 },
				{ letter:'C', frequency: .02782 },
				{ letter:'D', frequency: .04253 },
				{ letter:'E', frequency: .12702 },
				{ letter:'F', frequency: .02288 },
				{ letter:'G', frequency: .02015 },
				{ letter:'H', frequency: .06094 },
				{ letter:'I', frequency: .06966 },
				{ letter:'J', frequency: .00153 },
				{ letter:'K', frequency: .00772 },
				{ letter:'L', frequency: .04025 },
				{ letter:'M', frequency: .02406 },
				{ letter:'N', frequency: .06749 },
				{ letter:'O', frequency: .07507 },
				{ letter:'P', frequency: .01929 },
				{ letter:'Q', frequency: .00095 },
				{ letter:'R', frequency: .05987 },
				{ letter:'S', frequency: .06327 },
				{ letter:'T', frequency: .09056 },
				{ letter:'U', frequency: .02758 },
				{ letter:'V', frequency: .00978 },
				{ letter:'W', frequency: .02360 },
				{ letter:'X', frequency: .00150 },
				{ letter:'Y', frequency: .01974 },
				{ letter:'Z', frequency: .00074 }
			];

			var frequency_fr = [
				{ letter: "A", frequency: 0.087 },
				{ letter: "B", frequency: 0.0093 },
				{ letter: "C", frequency: 0.0315 },
				{ letter: "D", frequency: 0.0355 },
				{ letter: "E", frequency: 0.1783 },
				{ letter: "F", frequency: 0.0096 },
				{ letter: "G", frequency: 0.0097 },
				{ letter: "H", frequency: 0.0108 },
				{ letter: "I", frequency: 0.0697 },
				{ letter: "J", frequency: 0.0071 },
				{ letter: "K", frequency: 0.0016 },
				{ letter: "L", frequency: 0.0568 },
				{ letter: "M", frequency: 0.0323 },
				{ letter: "N", frequency: 0.0642 },
				{ letter: "O", frequency: 0.0535 },
				{ letter: "P", frequency: 0.0303 },
				{ letter: "Q", frequency: 0.0089 },
				{ letter: "R", frequency: 0.0643 },
				{ letter: "S", frequency: 0.0791 },
				{ letter: "T", frequency: 0.0711 },
				{ letter: "U", frequency: 0.0614 },
				{ letter: "V", frequency: 0.0183 },
				{ letter: "W", frequency: 0.0004 },
				{ letter: "X", frequency: 0.0042 },
				{ letter: "Y", frequency: 0.0019 },
				{ letter: "Z", frequency: 0.0021 }
			];

			var margin = {top: 20, right: 30, bottom: 30, left: 40},
			    width = 960 - margin.left - margin.right,
			    height = 500 - margin.top - margin.bottom;

			var x = d3.scaleBand()
			    .range([0, width])
			    .padding(0.1);

			var y = d3.scaleLinear()
			    .rangeRound([height, 0]);

			var chart = d3.select(".chart")
			    .attr("width", width + margin.left + margin.right)
			    .attr("height", height + margin.top + margin.bottom)
			  .append("g")
			    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

			function make_chart( data ) {
			  x.domain(data.map(function(d) { return d.letter; }));
			  y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

			  chart.append("g")
			      .attr("class", "x axis")
			      .attr("transform", "translate(0," + height + ")")
			      .call(d3.axisBottom(x));

			  chart.append("g")
			      .attr("class", "y axis")
			      .call(d3.axisLeft(y).ticks(10));

			  chart.selectAll(".bar")
			      .data(data)
			    .enter().append("rect")
			      .attr("class", "bar")
			      .attr("x", function(d) { return x(d.letter); })
			      .attr("y", function(d) { return y(d.frequency); })
			      .attr("height", function(d) { return height - y(d.frequency); })
			      .attr("width", x.bandwidth() );
			}

			make_chart( frequency );

		</script>
		<?php
	} elseif ( 'pie_sample' == $chart ) {
		?>
		<div class="vis-container Grid">
			<div class="Grid-cell">
				<h2>Pretest results</h2>
				<svg class="pie pretest" width="350" height="200"></svg>
			</div>
			<div class="Grid-cell">
				<h2>Posttest results</h2>
				<svg class="pie posttest" width="350" height="200"></svg>
			</div>
		</div>

		<div class="vis-container Grid">
			<div class="Grid-cell">
				<h2>Nested results</h2>
				<svg class="pie nested-tests"></svg>
			</div>
		</div>

		<script type="text/javascript">
			var tests = {
				pretest: [
					{ label: 'Never or almost never',  percent: 8.6 },
					{ label: 'Some days',  percent: 37.3 },
					{ label: 'Most days',  percent: 31.6 },
					{ label: 'Every day',  percent: 22.5 },
				],
				posttest: [
					{ label: 'Never or almost never',  percent: 5.7 },
					{ label: 'Some days',  percent: 35.4 },
					{ label: 'Most days',  percent: 32.4 },
					{ label: 'Every day',  percent: 26.5 },
				]
			};
			// console.log(tests);
			// console.log( tests['pretest'][0]['percent'] );
			// var arc = d3.arc()
			//   .innerRadius(60)
			//   .outerRadius(100);

		  // Red to blue
			// var color = d3.scaleOrdinal(['#ca0020','#f4a582','#92c5de','#0571b0']);
			// Purple to green
			// var color = d3.scaleOrdinal(['#7b3294', '#c2a5cf', '#a6dba0', '#008837']);
			// var color = d3.scaleOrdinal(['hsla(285, 49%, 95%, 1)', 'hsla(285, 49%, 75%, 1)', 'hsla(285, 49%, 50%, 1)', 'hsla(285, 49%, 36%, 1)']);
			// var color = d3.scaleSequential( d3.interpolateMagma );

			// Green
			var color = d3.scaleLinear()
			  .domain([0, 4])
			  .range(['hsla(117, 84%, 96%, 1)', 'hsla(117, 84%, 40%, 1)']);

		  // Blue
			var colorBlue = d3.scaleLinear()
			  .domain([0, 4])
			  .range(['hsla(195, 100%, 96%, 1)', 'hsla(195, 100%, 54%, 1)']);

			var pie = d3.pie()
			  .value(function(d) { return d.percent });

			// Build the pre and post-test pies
			jQuery.each( tests, function( index, data ) {
				build_pie_chart( index, data );
			});

			function build_pie_chart( index, data ){
				var slices = pie( data );

				var svg = d3.select('svg.pie.' + index );

				var rotation = 180 + data[0]['percent'] * 360 / 100;
				var g = svg.append('g')
					// The translate moves the center point of the pie from the upper left corner of the svg.
					.attr('transform', 'translate(240, 100) rotate( ' + rotation + ' )');

				g.selectAll('path.slice')
					.data(slices)
					.enter()
						.append('path')
							.attr('class', 'slice')
							.attr('d', d3.arc().innerRadius(60).outerRadius(100) )
							.attr('fill', function(d, i) {
								return color(i);
							});

				var legend = svg.append('g')
					.attr('class', 'legend')
					.selectAll('text')
					.data(slices)
					.enter();

				// Add containers for my legend entries.
				legendEntry = legend.append("g")
					.attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; })
					.style("font-size", "12px");

				legendEntry.insert("rect")
					// .attr("x", width - 18)
					.attr("width", 18)
					.attr("height", 18)
					.attr("fill", function(d, i) { return color(i); } );
				legendEntry.insert('text')
					.attr("y", "9")
					.attr("dy", ".35em")
					.text(function(d) { return '• ' + d.data.label; })
					.attr("x", 24)
					.attr('fill', function(d, i) { return color(i); });
			}

			// Build the pre and post-test pies
			jQuery.each( tests, function( index, data ) {
				build_nested_pie_chart( index, data );
			});

			function build_nested_pie_chart( index, data ){
				// var slices = pie( data );
				var width = 960,
				    height = 360,
						radius = Math.min(width, height) / 2,
						innerRad = ( index == 'pretest' ) ? radius * 0.3 : radius * 0.6,
						outerRad = ( index == 'pretest' ) ? radius * 0.5 : radius * 0.8;

				// Select the parent svg and set attributes.
				var svg = d3.select('svg.pie.nested-tests')
					.attr( 'width', width )
					.attr( "height", height );

				var rotation = 180 + data[0]['percent'] * 360 / 100;
				// console.log( "rotation: " + rotation );
				// Make a container for the pie.
				svg.append("g")
					.attr("class", "slices-" + index )
					// The translate moves the center point of the pie from the upper left corner of the svg.
					.attr('transform', "translate(" + width / 2 + "," + height / 2 + ") rotate(" + rotation + ")");
				// Make containers for the labels
				if ( index == 'posttest' ) {
					svg.append("g")
						.attr("class", "labels")
						.attr('transform', "translate(" + width / 2 + "," + height / 2 + ") rotate(" + rotation + ")")
						// .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; })
						.style("font-size", "12px");
					svg.append("g")
						.attr("class", "lines");
				}

				// var g = svg.append('g')
				// 	// The translate moves the center point of the pie from the upper left corner of the svg.
				// 	.attr('transform', 'translate(240, 120) rotate( ' + rotation + ' )');

				var arc = d3.arc().innerRadius( innerRad ).outerRadius( outerRad );

				var chooseColor = function( d, i ) {
					if ( index == 'pretest' ) {
						return colorBlue(i);
					} else {
						return color(i);
					}
				}

				var slice = svg.select( ".slices-" + index ).selectAll("path.slice")
						.data( pie(data) );

				slice.enter()
					.insert('path')
						.attr('class', 'slice')
						.attr('d', arc )
						.attr('fill', chooseColor );

				// Only add one legend.
				if ( index == 'posttest' ) {
					var text = svg.select(".labels")
						.selectAll('text')
						.data(pie(data));

					text.enter()
						.append("text")
						.text( function(d) { return d.data.label } )
						.attr("dy", ".35em")
						.style("font-size", "12px")
						.attr( "fill", "white" )
						.attr("transform", function(d) {
							var c = arc.centroid(d),
							x = c[0],
							y = c[1],
							// pythagorean theorem for hypotenuse
							h = Math.sqrt(x*x + y*y);
							return "translate(" + (x/h * radius * 0.9 ) +  ',' +
							(y/h * radius * 0.9 ) +  ") rotate(-" + rotation + ")";
						})
						.attr("text-anchor", function(d) {
							// are we past the center?
							var rotationRads = rotation * Math.PI / 180;
							return (d.endAngle + d.startAngle + 2 * rotationRads)/2 % (2 * Math.PI) > Math.PI ?
							"end" : "start";
						});
				}
			}
		</script>
		<?php
	} elseif ( 'stacked_sample_horizontal' == $chart ) {
		?>
		<div class="vis-container Grid">
			<div class="Grid-cell">
				<h2>Stacked results</h2>
				<svg class="stack horizontal" width="960" height="250"></svg>
			</div>
		</div>

		<script type="text/javascript">
			var data = [
					{ "id": "pretest", "never": 8.6, "some": 37.3, "most": 31.6, "daily": 22.5 },
					{ "id": "posttest", "never": 5.7, "some": 35.4, "most": 32.4, "daily": 26.5 },
				],
				labels = { "pretest": "Pre-Test", "posttest": "Post-Test", "never": "Never or Almost Never", "some": "Some Days", "most": "Most Days", "daily": "Every Day" },
				width = 960,
		    height = 360,
		    svg = d3.select("svg.stack.horizontal"),
		    margin = {top: 20, right: 60, bottom: 30, left: 40},
		    width = +svg.attr("width") - margin.left - margin.right,
		    height = +svg.attr("height") - margin.top - margin.bottom,
		    g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

				var y = d3.scaleBand()
				    .rangeRound([0, height])
				    .padding(0.1)
				    .align(0.1);

				var x = d3.scaleLinear()
				    .rangeRound([width, 0]);

				var z = d3.scaleOrdinal()
				    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

				var stack = d3.stack();

				// This returns an array( "pretest", "posttest" ). Which is not what I need for this.
				// We need an array of the other indicators to direct the stacking
				// var keys = data.map(function(d) {return d.id;});
				var keys = Object.keys( data[0] );
				// Remove the id column
				// var keys = data[0].columns.slice(1);
				var index = keys.indexOf("id");
				keys.splice( index, 1 );


				x.domain( [100, 0] );
			  y.domain( data.map(function(d) {return d.id;}) );
			  z.domain( keys );

// console.log( "horizontal stack keys" );
// console.log( keys );
// console.log( "data" );
// console.log( data );
// console.log( "stack.keys( keys )(data)" );
// console.log( stack.keys( keys )(data) );

			  var serie = g.selectAll(".serie")
			    .data( stack.keys( keys )(data) )
			    .enter().append("g")
			      .attr("class", "serie")
			      .attr("fill", function(d) { return z(d.key); });

			  serie.selectAll("rect")
			    .data(function(d) { return d; })
			    .enter().append("rect")
			      .attr("y", function(d) { return y(d.data.id); })
			      .attr("x", function(d) { return x(d[0]); })
			      .attr("width", function(d) { return x(d[1]) -  x(d[0]); })
			      .attr("height", y.bandwidth());

			  g.append("g")
			      .attr("class", "axis axis--x")
			      .attr("transform", "translate(0," + height + ")")
			      .attr("fill", "white")
			      .call(d3.axisBottom(x));

			  g.append("g")
			      .attr("class", "axis axis--y")
			      .attr("dy", "0.35em")
			      .attr("text-anchor", "start")
			      .attr("fill", "white")
			      .call(d3.axisLeft(y).ticks(10, "%"));

				  // var legend = serie.append("g")
				  //     .attr("class", "legend")
				  //     .attr("transform", function(d) { var d = d[d.length - 1]; return "translate(" + (x(d.data.State) + x.bandwidth()) + "," + ((y(d[0]) + y(d[1])) / 2) + ")"; });

				  // legend.append("line")
				  //     .attr("x1", -6)
				  //     .attr("x2", 6)
				  //     .attr("stroke", "#000");

				  // legend.append("text")
				  //     .attr("x", 9)
				  //     .attr("dy", "0.35em")
				  //     .attr("fill", "#000")
				  //     .style("font", "10px sans-serif")
				  //     .text(function(d) { return d; });

				function type(d, i, columns) {
				  for (i = 1, t = 0; i < columns.length; ++i) t += d[columns[i]] = +d[columns[i]];
				  d.total = t;
				  return d;
				}

		</script>
		<?php
	} elseif ( 'grouped_bar_one' == $chart ) {
		?>
		<div class="vis-container Grid">
			<div class="Grid-cell">
				<h2>Stacked results</h2>
				<svg class="grouped-bar" width="960" height="350"></svg>
			</div>
		</div>

		<script type="text/javascript">
			var data = [
					{ "id": "pretest", "never": 8.6, "some": 37.3, "most": 31.6, "daily": 22.5 },
					{ "id": "posttest", "never": 5.7, "some": 35.4, "most": 32.4, "daily": 26.5 },
				],
				labels = { "pretest": "Pre-Test", "posttest": "Post-Test", "never": "Never or Almost Never", "some": "Some Days", "most": "Most Days", "daily": "Every Day" },
		    svg = d3.select("svg.grouped-bar"),
		    margin = {top: 20, right: 60, bottom: 30, left: 40},
		    width = +svg.attr("width") - margin.left - margin.right,
		    height = +svg.attr("height") - margin.top - margin.bottom,
		    g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

				var x0 = d3.scaleBand()
				    .rangeRound([0, width])
				    .paddingInner(0.1)
				    .paddingOuter(0.1);

				var x1 = d3.scaleBand()
				    .padding(0.05);

				var y = d3.scaleLinear()
				    .rangeRound([height, 0]);

				var z = d3.scaleOrdinal()
				    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

				// This returns an array( "pretest", "posttest" ). Which is not what I need for this.
				// We need an array of the other indicators to direct the stacking
				// var keys = data.map(function(d) {return d.id;});
				var keys = Object.keys( data[0] );
				// Remove the id column
				// var keys = data[0].columns.slice(1);
				var index = keys.indexOf("id");
				keys.splice( index, 1 );


				x0.domain( data.map(function(d) { return d.id; }) );
				x1.domain(keys).rangeRound([0, x0.bandwidth()]);
		    y.domain([0, d3.max(data, function(d) { return d3.max(keys, function(key) { return d[key]; }); })]).nice();
			  z.domain( keys );

// console.log( "grouped bar stack keys" );
// console.log( keys );
// console.log( "data" );
// console.log( data );
// console.log( "stack.keys( keys )(data)" );
// console.log( stack.keys( keys )(data) );
// console.log( "stack.keys( keys )(data)" );
// console.log( y );

			  g.append("g")
			    .selectAll("g")
			    .data(data)
			    .enter().append("g")
			      .attr("transform", function(d) { return "translate(" + x0(d.id) + ",0)"; })
			    .selectAll("rect")
			    .data(function(d) { return keys.map(function(key) { return {key: key, value: d[key]}; }); })
			    .enter().append("rect")
			      .attr("x", function(d) { return x1(d.key); })
			      .attr("y", function(d) { return y(d.value); })
			      .attr("width", x1.bandwidth())
			      .attr("height", function(d) { return height - y(d.value); })
			      .attr("fill", function(d) { return z(d.key); });

			  g.append("g")
			      .attr("class", "axis")
			      .attr("transform", "translate(0," + height + ")")
			      .call(d3.axisBottom(x0));

			  var axisY = g.append("g")
			      .attr("class", "axis")
			      .call(d3.axisLeft(y).ticks(null, "s"));

			    axisY.append("text")
			      .attr("x", 2)
			      .attr("y", y(y.ticks().pop()) + 0.5)
			      .attr("dy", "0.32em")
			      .attr("fill", "white")
			      .attr("font-weight", "bold")
			      .attr("text-anchor", "start")
			      .text("Percent");
			    // axisY.selectAll("path")
			    //  .style( "stroke", "white" );
			    // axisY.selectAll("line")
			    //  .style( "stroke", "white" );
			    // axisY.selectAll("text")
			    //  .style( "fill", "white" );

			  var legend = g.append("g")
			      .attr("font-family", "sans-serif")
			      .attr("font-size", 10)
			      .attr("text-anchor", "end")
			    .selectAll("g")
			    .data(keys.slice().reverse())
			    .enter().append("g")
			      .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

			  legend.append("rect")
			      .attr("x", width - 19)
			      .attr("width", 19)
			      .attr("height", 19)
			      .attr("fill", z);

			  legend.append("text")
			      .attr("x", width - 24)
			      .attr("y", 9.5)
			      .attr("dy", "0.32em")
			      .text(function(d) { return d; });

		</script>
		<?php
	} elseif ( 'grouped_bar_two' == $chart ) {
		?>
		<div class="vis-container Grid">
			<div class="Grid-cell">
				<h2>Stacked results</h2>
				<svg class="grouped-bar-two" width="960" height="350"></svg>
			</div>
		</div>

		<script type="text/javascript">
			var data = [
					{ "id": "pretest", "never": 8.6, "some": 37.3, "most": 31.6, "daily": 22.5 },
					{ "id": "posttest", "never": 5.7, "some": 35.4, "most": 32.4, "daily": 26.5 },
				],
				labels = { "pretest": "Pre-Test", "posttest": "Post-Test", "never": "Never or Almost Never", "some": "Some Days", "most": "Most Days", "daily": "Every Day" },
		    svg = d3.select("svg.grouped-bar-two"),
		    margin = {top: 20, right: 60, bottom: 30, left: 40},
		    width = +svg.attr("width") - margin.left - margin.right,
		    height = +svg.attr("height") - margin.top - margin.bottom,
		    g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

				var x0 = d3.scaleBand()
				    .rangeRound([0, width])
				    .paddingInner(0.1)
				    .paddingOuter(0.1);

				var x1 = d3.scaleBand()
				    .padding(0.05);

				var y = d3.scaleLinear()
				    .rangeRound([height, 0]);

				var color = d3.scaleOrdinal()
				    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

				// This returns an array( "pretest", "posttest" ). Which is not what I need for this.
				// We need an array of the other indicators to direct the stacking
				// var keys = data.map(function(d) {return d.id;});
				var keys = Object.keys( data[0] );
				// Remove the id column
				// var keys = data[0].columns.slice(1);
				var index = keys.indexOf("id");
				keys.splice( index, 1 );


				x0.domain( keys );
				x1.domain( data.map(function(d) { return d.id; }) ).rangeRound([0, x0.bandwidth()]);
		    y.domain([0, d3.max(data, function(d) { return d3.max(keys, function(key) { return d[key]; }); })]).nice();
			  color.domain( d3.range(2) );

// console.log( "grouped bar stack keys" );
// console.log( keys );
// console.log( "data" );
// console.log( data );
// console.log( "stack.keys( keys )(data)" );
// console.log( stack.keys( keys )(data) );
// console.log( "stack.keys( keys )(data)" );
// console.log( y );

			  g.append("g")
			    .selectAll("g")
			    .data(data)
			    .enter().append("g")
			      .attr("transform", function(d) { return "translate(" + x1(d.id) + ",0)"; })
			    .selectAll("rect")
			    .data(function(d) { return keys.map(function(key) { return {key: key, value: d[key]}; }); })
			    .enter().append("rect")
			      .attr("x", function(d) { return x0(d.key); })
			      .attr("y", function(d) { return y(d.value); })
			      .attr("width", x1.bandwidth())
			      .attr("height", function(d) { return height - y(d.value); })
			      .attr("fill", function(d, i) { console.log( "** in data" ); console.log( d ); console.log( i ); return color(i); });

			  g.append("g")
			      .attr("class", "axis")
			      .attr("transform", "translate(0," + height + ")")
			      .call(d3.axisBottom(x0));

			  var axisY = g.append("g")
			      .attr("class", "axis")
			      .call(d3.axisLeft(y).ticks(null, "s"));

			    axisY.append("text")
			      .attr("x", 2)
			      .attr("y", y(y.ticks().pop()) + 0.5)
			      .attr("dy", "0.32em")
			      .attr("fill", "white")
			      .attr("font-weight", "bold")
			      .attr("text-anchor", "start")
			      .text("Percent");
			    // axisY.selectAll("path")
			    //  .style( "stroke", "white" );
			    // axisY.selectAll("line")
			    //  .style( "stroke", "white" );
			    // axisY.selectAll("text")
			    //  .style( "fill", "white" );

			  var legend = g.append("g")
			      .attr("font-family", "sans-serif")
			      .attr("font-size", 10)
			      .attr("text-anchor", "end")
			    .selectAll("g")
			    .data(keys.slice().reverse())
			    .enter().append("g")
			      .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

			  legend.append("rect")
			      .attr("x", width - 19)
			      .attr("width", 19)
			      .attr("height", 19)
			      .attr("fill", color );

			  legend.append("text")
			      .attr("x", width - 24)
			      .attr("y", 9.5)
			      .attr("dy", "0.32em")
			      .text(function(d) { return d; });

		</script>
		<?php
	} elseif ( 'stacked_sample' == $chart ) {
		?>
		<div class="vis-container Grid">
			<div class="Grid-cell">
				<h2>Nested results</h2>
				<svg class="stack vertical" width="960" height="500"></svg>
			</div>
		</div>

		<script type="text/javascript">
			var svg = d3.select("svg.stack.vertical"),
			    margin = {top: 20, right: 20, bottom: 30, left: 40},
			    width = +svg.attr("width") - margin.left - margin.right,
			    height = +svg.attr("height") - margin.top - margin.bottom,
			    g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");

			var x = d3.scaleBand()
			    .rangeRound([0, width])
			    .padding(0.1)
			    .align(0.1);

			var y = d3.scaleLinear()
			    .rangeRound([height, 0]);

			var z = d3.scaleOrdinal()
			    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

			var stack = d3.stack();

			d3.csv( "<?php echo csed_get_plugin_base_uri() . 'public/data-files/stacked-bar.csv'; ?>" , type, function(error, data) {
			  if (error) throw error;

			  data.sort(function(a, b) { return b.total - a.total; });
			  var keys = data.columns.slice(1);

			  x.domain(data.map(function(d) { return d.State; }));
			  y.domain([0, d3.max(data, function(d) { return d.total; })]).nice();
			  z.domain( keys );

// console.log( "stack keys" );
// console.log( keys );
// console.log( "data" );
// console.log( data );
// console.log( "stack.keys( keys )(data)" );
// console.log( stack.keys( keys )(data) );

			  g.selectAll(".serie")
			    .data( stack.keys( keys )(data) )
			    .enter().append("g")
			      .attr("class", "serie")
			      .attr("fill", function(d) { return z(d.key); })
			    .selectAll("rect")
			    .data(function(d) { return d; })
			    .enter().append("rect")
			      .attr("x", function(d) { return x(d.data.State); })
			      .attr("y", function(d) { return y(d[1]); })
			      .attr("height", function(d) { return y(d[0]) - y(d[1]); })
			      .attr("width", x.bandwidth());

			  g.append("g")
			      .attr("class", "axis axis--x")
			      .attr("transform", "translate(0," + height + ")")
			      .call(d3.axisBottom(x));

			  g.append("g")
			      .attr("class", "axis axis--y")
			      .call(d3.axisLeft(y).ticks(10, "s"))
			    .append("text")
			      .attr("x", 2)
			      .attr("y", y(y.ticks(10).pop()))
			      .attr("dy", "0.35em")
			      .attr("text-anchor", "start")
			      .attr("fill", "#000")
			      .text("Population");

			  var legend = g.selectAll(".legend")
			    .data(keys)
			    .enter().append("g")
			      .attr("class", "legend")
			      .attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; })
			      .style("font", "10px sans-serif");

			  legend.append("rect")
			      .attr("x", width - 18)
			      .attr("width", 18)
			      .attr("height", 18)
			      .attr("fill", z);

			  legend.append("text")
			      .attr("x", width - 24)
			      .attr("y", 9)
			      .attr("dy", ".35em")
			      .attr("text-anchor", "end")
			      .text(function(d) { return d; });
			});

			function type(d, i, columns) {
			  for (i = 1, t = 0; i < columns.length; ++i) t += d[columns[i]] = +d[columns[i]];
			  d.total = t;
			  return d;
			}

		</script>
		<?php
	} else {
		?>
		<style>
		body{
			width:1060px;
			margin:50px auto;
		}
		path {  stroke: #fff; }
		path:hover {  opacity:0.9; }
		rect:hover {  fill:blue; }
		.axis {  font: 10px sans-serif; }
		.legend tr{    border-bottom:1px solid grey; }
		.legend tr:first-child{    border-top:1px solid grey; }

		.axis path,
		.axis line {
		  fill: none;
		  stroke: #000;
		  shape-rendering: crispEdges;
		}

		.x.axis path {  display: none; }
		.legend{
			margin-bottom:76px;
			display:inline-block;
			border-collapse: collapse;
			border-spacing: 0px;
		}
		.legend td{
			padding:4px 5px;
			vertical-align:bottom;
		}
		.legendFreq, .legendPerc{
			align:right;
			width:50px;
		}

		</style>

		<div id='dashboard'>
		</div>

		<script>
		function dashboard(id, fData){
			var barColor = 'steelblue';
			function segColor(c){ return {low:"#807dba", mid:"#e08214",high:"#41ab5d"}[c]; }

			// compute total for each state.
			fData.forEach(function(d){d.total=d.freq.low+d.freq.mid+d.freq.high;});

			// function to handle histogram.
			function histoGram(fD){
				var hG={},    hGDim = {t: 60, r: 0, b: 30, l: 0};
				hGDim.w = 500 - hGDim.l - hGDim.r,
				hGDim.h = 300 - hGDim.t - hGDim.b;

				//create svg for histogram.
				var hGsvg = d3.select(id).append("svg")
					.attr("width", hGDim.w + hGDim.l + hGDim.r)
					.attr("height", hGDim.h + hGDim.t + hGDim.b).append("g")
					.attr("transform", "translate(" + hGDim.l + "," + hGDim.t + ")");

				// create function for x-axis mapping.
				var x = d3.scaleOrdinal().range([0, hGDim.w], 0.1)
						.domain(fD.map(function(d) { return d[0]; }));

				// Add x-axis to the histogram svg.
				hGsvg.append("g").attr("class", "x axis")
					.attr("transform", "translate(0," + hGDim.h + ")")
					.call(d3.svgAxis().scale(x).orient("bottom"));

				// Create function for y-axis map.
				var y = d3.scaleLinear().range([hGDim.h, 0])
						.domain([0, d3.max(fD, function(d) { return d[1]; })]);

				// Create bars for histogram to contain rectangles and freq labels.
				var bars = hGsvg.selectAll(".bar").data(fD).enter()
						.append("g").attr("class", "bar");

				//create the rectangles.
				bars.append("rect")
					.attr("x", function(d) { return x(d[0]); })
					.attr("y", function(d) { return y(d[1]); })
					.attr("width", x.rangeBand())
					.attr("height", function(d) { return hGDim.h - y(d[1]); })
					.attr('fill',barColor)
					.on("mouseover",mouseover)// mouseover is defined below.
					.on("mouseout",mouseout);// mouseout is defined below.

				//Create the frequency labels above the rectangles.
				bars.append("text").text(function(d){ return d3.format(",")(d[1])})
					.attr("x", function(d) { return x(d[0])+x.rangeBand()/2; })
					.attr("y", function(d) { return y(d[1])-5; })
					.attr("text-anchor", "middle");

				function mouseover(d){  // utility function to be called on mouseover.
					// filter for selected state.
					var st = fData.filter(function(s){ return s.State == d[0];})[0],
						nD = d3.keys(st.freq).map(function(s){ return {type:s, freq:st.freq[s]};});

					// call update functions of pie-chart and legend.
					pC.update(nD);
					leg.update(nD);
				}

				function mouseout(d){    // utility function to be called on mouseout.
					// reset the pie-chart and legend.
					pC.update(tF);
					leg.update(tF);
				}

				// create function to update the bars. This will be used by pie-chart.
				hG.update = function(nD, color){
					// update the domain of the y-axis map to reflect change in frequencies.
					y.domain([0, d3.max(nD, function(d) { return d[1]; })]);

					// Attach the new data to the bars.
					var bars = hGsvg.selectAll(".bar").data(nD);

					// transition the height and color of rectangles.
					bars.select("rect").transition().duration(500)
						.attr("y", function(d) {return y(d[1]); })
						.attr("height", function(d) { return hGDim.h - y(d[1]); })
						.attr("fill", color);

					// transition the frequency labels location and change value.
					bars.select("text").transition().duration(500)
						.text(function(d){ return d3.format(",")(d[1])})
						.attr("y", function(d) {return y(d[1])-5; });
				}
				return hG;
			}

			// function to handle pieChart.
			function pieChart(pD){
				var pC ={},    pieDim ={w:250, h: 250};
				pieDim.r = Math.min(pieDim.w, pieDim.h) / 2;

				// create svg for pie chart.
				var piesvg = d3.select(id).append("svg")
					.attr("width", pieDim.w).attr("height", pieDim.h).append("g")
					.attr("transform", "translate("+pieDim.w/2+","+pieDim.h/2+")");

				// create function to draw the arcs of the pie slices.
				var arc = d3.svg.arc().outerRadius(pieDim.r - 10).innerRadius(0);

				// create a function to compute the pie slice angles.
				var pie = d3.layout.pie().sort(null).value(function(d) { return d.freq; });

				// Draw the pie slices.
				piesvg.selectAll("path").data(pie(pD)).enter().append("path").attr("d", arc)
					.each(function(d) { this._current = d; })
					.style("fill", function(d) { return segColor(d.data.type); })
					.on("mouseover",mouseover).on("mouseout",mouseout);

				// create function to update pie-chart. This will be used by histogram.
				pC.update = function(nD){
					piesvg.selectAll("path").data(pie(nD)).transition().duration(500)
						.attrTween("d", arcTween);
				}
				// Utility function to be called on mouseover a pie slice.
				function mouseover(d){
					// call the update function of histogram with new data.
					hG.update(fData.map(function(v){
						return [v.State,v.freq[d.data.type]];}),segColor(d.data.type));
				}
				//Utility function to be called on mouseout a pie slice.
				function mouseout(d){
					// call the update function of histogram with all data.
					hG.update(fData.map(function(v){
						return [v.State,v.total];}), barColor);
				}
				// Animating the pie-slice requiring a custom function which specifies
				// how the intermediate paths should be drawn.
				function arcTween(a) {
					var i = d3.interpolate(this._current, a);
					this._current = i(0);
					return function(t) { return arc(i(t));    };
				}
				return pC;
			}

			// function to handle legend.
			function legend(lD){
				var leg = {};

				// create table for legend.
				var legend = d3.select(id).append("table").attr('class','legend');

				// create one row per segment.
				var tr = legend.append("tbody").selectAll("tr").data(lD).enter().append("tr");

				// create the first column for each segment.
				tr.append("td").append("svg").attr("width", '16').attr("height", '16').append("rect")
					.attr("width", '16').attr("height", '16')
					.attr("fill",function(d){ return segColor(d.type); });

				// create the second column for each segment.
				tr.append("td").text(function(d){ return d.type;});

				// create the third column for each segment.
				tr.append("td").attr("class",'legendFreq')
					.text(function(d){ return d3.format(",")(d.freq);});

				// create the fourth column for each segment.
				tr.append("td").attr("class",'legendPerc')
					.text(function(d){ return getLegend(d,lD);});

				// Utility function to be used to update the legend.
				leg.update = function(nD){
					// update the data attached to the row elements.
					var l = legend.select("tbody").selectAll("tr").data(nD);

					// update the frequencies.
					l.select(".legendFreq").text(function(d){ return d3.format(",")(d.freq);});

					// update the percentage column.
					l.select(".legendPerc").text(function(d){ return getLegend(d,nD);});
				}

				function getLegend(d,aD){ // Utility function to compute percentage.
					return d3.format("%")(d.freq/d3.sum(aD.map(function(v){ return v.freq; })));
				}

				return leg;
			}

			// calculate total frequency by segment for all state.
			var tF = ['low','mid','high'].map(function(d){
				return {type:d, freq: d3.sum(fData.map(function(t){ return t.freq[d];}))};
			});

			// calculate total frequency by state for all segment.
			var sF = fData.map(function(d){return [d.State,d.total];});

			var hG = histoGram(sF), // create the histogram.
				pC = pieChart(tF), // create the pie-chart.
				leg= legend(tF);  // create the legend.
		}
		</script>

		<script>
		var freqData=[
		{State:'AL',freq:{low:4786, mid:1319, high:249}}
		,{State:'AZ',freq:{low:1101, mid:412, high:674}}
		,{State:'CT',freq:{low:932, mid:2149, high:418}}
		,{State:'DE',freq:{low:832, mid:1152, high:1862}}
		,{State:'FL',freq:{low:4481, mid:3304, high:948}}
		,{State:'GA',freq:{low:1619, mid:167, high:1063}}
		,{State:'IA',freq:{low:1819, mid:247, high:1203}}
		,{State:'IL',freq:{low:4498, mid:3852, high:942}}
		,{State:'IN',freq:{low:797, mid:1849, high:1534}}
		,{State:'KS',freq:{low:162, mid:379, high:471}}
		];

		dashboard('#dashboard',freqData);
		</script>
		<?php
	} // end else
}