<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ asset('css/index.css') }}">
	</head>
	<body class="container">
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
						<div class="label label-info">STABLE</div>
					</div>
				</div>
				<div class="row collapse" id="stockDetail">
					<!-- chart -->
				</div>
			</div>
		</div>
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
		<script src="{{ asset('plugins/vue/vue.js') }}"></script>
	</body>
</html>