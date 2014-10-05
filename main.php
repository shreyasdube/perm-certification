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
						<div class="col-lg-6">
							<div class="input-group">
								<input id="employerNameTextBox" type="text" class="form-control" value="Akamai Technologies">
								<span class="input-group-btn">
									<button id="byEmployerButton" class="btn btn-default" type="button">Search!</button>
								</span>
							</div><!-- /input-group -->
						</div><!-- /.col-lg-6 -->
					</div><!-- /.row -->
				</div>
				<!-- Table -->
				<table id="byEmployerTable" class="table"></table>
			</div>
		</div>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery.js"></script>

        <!-- d3 -->
        <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>

        <!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			d3.select("#byEmployerButton").on("click", function(d) {
                var employerName = $("#employerNameTextBox").val();
                fetchPermsByEmployer(employerName);
            });

            var fetchPermsByEmployer = function(employerName) {
            	d3.json("/employer?name=" + employerName, function(error, json) {
            		console.log(json);
            		showPermsByEmployerTable("#byEmployerTable", json);
            	});
            }

            var showPermsByEmployerTable = function(tableId, json) {
            	var table = d3.select(tableId).html("");

            	table
                    .append("thead")
                    .append("tr")
                    .selectAll("th")
                    .data(["#", "ID", "Case Number", "Approval Date", "Priority Date", "Employer Name", "State", "Job Title"])
                    .enter().append("th")
                    .text(function(d) {
                        return d;
                    });

                table.append("tbody")
                    .selectAll("tr")
                    .data(json.result)
                    .enter().append("tr")
                    .selectAll("td")
                    .data(function(d, i) {
                        return [i + 1, d.id, d.cn, d.pD, d.cCD, d.fN, d.s, d.pT];
                    })
                    .enter().append("td").append("span")
                    .text(function(d) {
                        return d;
                    });

            }
		</script>
    </body>
</html>