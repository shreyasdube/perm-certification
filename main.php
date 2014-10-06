<!DOCTYPE html>
<html>
    <head>
        <title>PERM Certification Status</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" media="screen">
    </head>
    <body>
    	<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">By Employer</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="input-group">
								<input id="employerNameTextBox" type="text" class="form-control" value="Akamai Technologies">
								<span class="input-group-btn">
									<button id="byEmployerButton" class="btn btn-default" type="button">Search!</button>
								</span>
							</div><!-- /input-group -->
						</div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
					<div class="row">
						<div class="col-lg-12">
							<br />
							<div id="byEmployerLegend"></div>
						</div>
					</div>
				</div>
				<!-- Table -->
				<table id="byEmployerTable" class="table"></table>
			</div>

			<div style="text-align: center; font-size: small; color: #c0c0c0;">
				<p>
					Authored by <a href='https://www.linkedin.com/in/shreyasdube' target='_blank'>Shreyas Dube</a> | Made with <span class="glyphicon glyphicon-heart"></span> in Cambridge, MA
					<br />
					Data by <a href='http://dolstats.com/' target="_blank">dolstats.com</a>
				</p>
			</div>
		</div>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>

        <!-- d3 -->
        <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>

        <!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

		<script type="text/javascript">
            var colors = ['#1a9641', '#a6d96a', '#ffffbf', '#fdae61', '#d7191c'];
            var scale = d3.scale.threshold()
                .domain([60, 90, 150, 360])
                .range(colors);

            var drawLegend = function() {
                var legend = d3.select("#byEmployerLegend").html("Legend (days): ");

                legend.selectAll("span")
                    .data(colors)
                    .enter().append("span")
                    .attr("class", "label label-default")
                    .text(function(d) {
                        return scale.invertExtent(d);
                    })
                    .style("margin-right", "5px")
                    .style("background-color", function(d) {
                        return d;
                    })
                    .style("color", "black");
            }

            drawLegend();

			d3.select("#byEmployerButton").on("click", function(d) {
                var employerName = $("#employerNameTextBox").val();
                fetchPermsByEmployer(employerName);
            });

            var fetchPermsByEmployer = function(employerName) {
            	d3.json("/employer?name=" + employerName, function(error, json) {
            		var data = json.result;
            		data.sort(function(a, b) {
            			return d3.descending(
            				Date.parse(a.pD), 
            				Date.parse(b.pD));
            		});
            		showPermsByEmployerTable("#byEmployerTable", data);
            	});
            }

            var showPermsByEmployerTable = function(tableId, data) {
            	var table = d3.select(tableId).html("");
                
            	table
                    .append("thead")
                    .append("tr")
                    .selectAll("th")
                    .data(["#", "Case Number", "Approval Date", "Priority Date", "Employer Name", "State", "Job Title", "Days"])
                    .enter().append("th")
                    .text(function(d) {
                        return d;
                    });

                table.append("tbody")
                    .selectAll("tr")
                    .data(data)
                    .enter().append("tr")
                    .style("background-color", function(d, i) {
                        var days = diffDates(d.pD, d.cCD);
                        return scale(days);
                    })
                    .selectAll("td")
                    .data(function(d, i) {
                        return [i + 1, d.cn, d.pD, d.cCD, d.fN, d.s, d.pT, [d.pD, d.cCD]];
                    })
                    .enter().append("td").append("span")
                    .html(function(d, i) {
                    	if (i === 1) {
                    		return "<a href='http://icert.doleta.gov/index.cfm?event=ehLCJRExternal.dspCert&doc_id=3&visa_class_id=6&id=" 
                    			+ data[i].id + "' target='_blank'>" + d + "</a>";
                    	}

                        if (i == 7) {
                            return diffDates(d[0], d[1]);
                        }
                        return d;
                    });

            }

            var secondsToDays = function(seconds) {
                return Math.round(seconds / (1000 * 60 * 60 * 24));
            }

            var diffDates = function(date1, date2) {
                return secondsToDays(
                        Date.parse(date1) - Date.parse(date2)
                    );
            }
		</script>
    </body>
</html>