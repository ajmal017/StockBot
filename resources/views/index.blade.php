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
				<stock v-for="stock in stocks" :key="stock[0].stockCode" :stock-code="stock[0].stockCode" :stock-price="stock[0].close"></stock>
			</div>
		</div>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script src="{{ asset('plugins/jquery/jquery.slim.js') }}"></script>
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
		<script src="{{ asset('plugins/vue/vue.js') }}"></script>
		<script src="{{ asset('plugins/vue-resource/vue-resource.js') }}"></script>
		
		<script src="{{ asset('js/component/stock.js') }}"></script>

		<script src="{{ asset('js/googleChart.js') }}"></script>
		<script src="{{ asset('js/stockChart.js') }}"></script>
		<script src="{{ asset('js/stockList.js') }}"></script>

		<script>
			let gChart = new GoogleChart(google);

			let stockChart = new StockChart('#chart', gChart);
			stockChart.app.getStockData('WIKA');
			
			let stockList = new StockList('#summary', gChart);
			stockList.app.generateStock();
		</script>
	</body>
</html>