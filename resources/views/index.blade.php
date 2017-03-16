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
			<div class="panel panel-default" id="stockChart">
				<div id="chart"></div>
			</div>
			<div id="summary">
				<div class="panel panel-info">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-3">
								<div class="stock-code">BUDI</div>
								<div class="stock-price">98</div>
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
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script src="{{ asset('plugins/jquery/jquery.slim.js') }}"></script>
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
		<script src="{{ asset('plugins/vue/vue.js') }}"></script>
		<script src="{{ asset('plugins/vue-resource/vue-resource.js') }}"></script>

		<script src="{{ asset('js/googleChart.js') }}"></script>
		<script src="{{ asset('js/stockChart.js') }}"></script>
		<script src="{{ asset('js/stockList.js') }}"></script>

		<script>
			let gChart = new GoogleChart(google);

			let stockChart = new StockChart('#chart', gChart);
			stockChart.app.getStockData('WIKA');
		</script>
	</body>
</html>