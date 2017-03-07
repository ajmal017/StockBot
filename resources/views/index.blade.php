<!DOCTYPE html>
<html>
	<head>
		<title>StockBot</title>
		<link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap-theme.css') }}">
		<link rel="stylesheet" href="{{ asset('css/index.css') }}">
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand">StockBot</a>
				</div>
			</div>
		</nav>
		<div class="container">
			<div class="panel panel-info" role="button" data-toggle="collapse" href="#stockDetail" aria-expanded="false" aria-controls="stockDetails">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							<div class="stock-code">BUDI</div>
						</div>
						<div class="col-sm-3">
							<div>RSI</div>
							<div class="label label-success">OVERSOLD!</div>
						</div>
						<div class="col-sm-3">
							<div>MACD</div>
							<div class="label label-danger">REBOUND DOWN!</div>
						</div>
						<div class="col-sm-3">
							<div>STOCHASTIC</div>
							<div class="label label-warning">STABLE</div>
						</div>
					</div>
					<div class="row collapse" id="stockDetail">
						<!-- chart -->
					</div>
				</div>
			</div>
		</div>
		<script src="{{ asset('plugins/jquery/jquery.slim.js') }}"></script>
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
		<script src="{{ asset('plugins/vue/vue.js') }}"></script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">
			google.charts.load('current', {packages: ['corechart']});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {

			}
		</script>
	</body>
</html>