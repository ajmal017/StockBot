@extends('base')

@section('styles')
	<link rel="stylesheet" href="{{ asset('css/progress-indicator.css') }}"/>
@append

@section('content')
	<div class="panel panel-info chart-detail" id="chart">
		<div class="panel-body text-center">
			<div class="row">
				<div class="col-sm-12" id="stock-code" style="margin-bottom: 10px;">PLEASE SELECT A STOCK</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div>RSI <span class="label" id="rsi-label"></span></div>
					<div id="rsi-chart" class="chart"></div>
				</div>
				<div class="col-sm-4">
					<div>MACD <span class="label" id="macd-label"></span></div>
					<div id="macd-chart" class="chart"></div>
				</div>
				<div class="col-sm-4">
					<div>STOCHASTIC <span class="label" id="stoch-label"></span></div>
					<div id="stoch-chart" class="chart"></div>
				</div>
			</div>
		</div>
	</div>
	<div id="summary">
		@foreach ($data['summary'] as $item)
			<div class="panel panel-info">
				<div class="panel-body text-center">
					<div class="row stock">
						<div class="col-sm-1 text-left">
							<a href="{{ route('stock', ['stockCode' => $item['stockCode']]) }}">{{ $item['stockCode'] }}</a>
						</div>
						<div class="col-sm-2 text-right">
							<strong>{{ $item['price'] }}</strong>
						</div>
						<div class="col-sm-2 text-left">
							<span class="{{ $item['change'] >= 0 ? 'text-success' : 'text-danger' }}">{{ $item['change'] }} ({{ $item['percent'] }}%)</span>
						</div>
						<div class="col-sm-1 text-danger">
							<strong>SELL</strong>
						</div>
						<div class="col-sm-4">
							<div class="progress-indicator">
								<div class="bubble" style="left:{{ 50 + ($item['overall'] * 50 / 8) }}%;">{{ $item['overall'] }}</div>
							</div>
						</div>
						<div class="col-sm-1 text-success">
							<strong>BUY</strong>
						</div>
						<div class="col-sm-1">
							<button class="btn btn-sm btn-primary btn-chart" type="button"
							        data-rsi="{{ $item['rsi'] }}" data-macd="{{ $item['macd'] }}" data-stoch="{{ $item['stoch'] }}"
							        data-insight="{{ $item['insight'] }}" data-code="{{ $item['stockCode'] }}">
								<i class="glyphicon glyphicon-plus"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@append

@section('scripts')
	<script src="{{ asset('js/rsiChart.js') }}"></script>
	<script src="{{ asset('js/macdChart.js') }}"></script>
	<script src="{{ asset('js/stochChart.js') }}"></script>
	<script src="{{ asset('js/chartOptions.js') }}"></script>

	<script>
		let chartElements = {};
		
		let rsiChart = new RsiChart(google);
		let macdChart = new MacdChart(google);
		let stochChart = new StochChart(google);

		$(function () {
			chartElements = {
				rsi: {
					label: $('#rsi-label'),
					chart: $('#rsi-chart')
				},
				macd: {
					label: $('#macd-label'),
					chart: $('#macd-chart')
				},
				stoch: {
					label: $('#stoch-label'),
					chart: $('#stoch-chart')
				}
			};

			$('.btn-chart').click(function() {
				drawChart($(this));
			});
		});

		function drawChart(element) {
			let insight = element.data('insight');

			$('#stock-code').html(element.data('code'));

			chartElements.rsi.label.removeClass('label-danger label-success label-default')
				.addClass(insight['rsi']['label'])
				.html(insight['rsi']['text']);
			chartElements.rsi.chart.removeClass('danger success')
				.addClass(insight['rsi']['chart']);
			rsiChart.draw(chartElements.rsi.chart[0], element.data('rsi'), '', rsiOptions);


			chartElements.macd.label.removeClass('label-danger label-success label-default')
				.addClass(insight['macd']['label'])
				.html(insight['macd']['text']);
			chartElements.macd.chart.removeClass('danger success')
				.addClass(insight['macd']['chart']);
			macdChart.draw(chartElements.macd.chart[0], element.data('macd'), '', macdOptions);

			chartElements.stoch.label.removeClass('label-danger label-success label-default')
				.addClass(insight['stoch']['label'])
				.html(insight['stoch']['text']);
			chartElements.stoch.chart.removeClass('danger success')
				.addClass(insight['stoch']['chart']);
			stochChart.draw(chartElements.stoch.chart[0], element.data('stoch'), '', stochOptions);
		}
	</script>
@append