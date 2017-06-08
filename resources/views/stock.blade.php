@extends('base')

@section('styles')
	<link rel="stylesheet" href="{{ asset('css/progress-indicator.css') }}"/>
@append

@section('content')
	<div id="detail">
		<div class="panel panel-info">
			<div class="panel-body text-center">
				<div class="row stock">
					<div class="col-sm-1 text-left">
						<span class="stock-code" id="stock-insight" data-insight="{{ $data['details']['insight'] }}">
							{{ $data['details']['stockCode'] }}
						</span>
					</div>
					<div class="col-sm-2 text-right">
						<span class="stock-price"><strong>{{ $data['details']['price'] }}</strong></span>
					</div>
					<div class="col-sm-2 text-left">
						<span class="stock-change {{ $data['details']['change'] >= 0 ? 'text-success' : 'text-danger' }}">{{ $data['details']['change'] }} ({{ $data['details']['percent'] }}%)</span>
					</div>
					<div class="col-sm-1 text-danger">
						<strong>SELL</strong>
					</div>
					<div class="col-sm-4">
						<div class="progress-indicator">
							<div class="bubble" style="left:{{ 50 + ($data['details']['overall'] * 50 / 8) }}%;">{{ $data['details']['overall'] }}</div>
						</div>
					</div>
					<div class="col-sm-1 text-success">
						<strong>BUY</strong>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div id="candlestick-chart" class="chart" data-candlestick="{{ $data['details']['historicPrices'] }}" style="min-height: 300px;"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div>RSI <span class="label" id="rsi-label"></span></div>
						<div id="rsi-chart" class="chart" data-rsi="{{ $data['details']['rsi'] }}"></div>
					</div>
					<div class="col-sm-6">
						<div>MACD <span class="label" id="macd-label"></span></div>
						<div id="macd-chart" class="chart" data-macd="{{ $data['details']['macd'] }}"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div>STOCHASTIC <span class="label" id="stoch-label"></span></div>
						<div id="stoch-chart" class="chart" data-stoch="{{ $data['details']['stoch'] }}"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
@append

@section('scripts')
    <script src="{{ asset('js/candlestickChart.js') }}"></script>
    <script src="{{ asset('js/rsiChart.js') }}"></script>
    <script src="{{ asset('js/macdChart.js') }}"></script>
    <script src="{{ asset('js/stochChart.js') }}"></script>
	<script src="{{ asset('js/chartOptions.js') }}"></script>

    <script>
	    let chartElements = {};
	    let candlestickChart = new CandlestickChart(google, 1120, 300);
	    let rsiChart = new RsiChart(google, 545, 200);
	    let macdChart = new MacdChart(google, 545, 200);
	    let stochChart = new StochChart(google, 545, 200);

	    $(function() {
		    let insight = $('#stock-insight').data('insight');

		    chartElements = {
		    	candlestick: {
				    chart: $('#candlestick-chart')
			    },
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

		    rsiOptions.legend = 'bottom';
		    stochOptions.legend = 'bottom';
		    macdOptions.legend = 'bottom';

		    candlestickChart.draw(chartElements.candlestick.chart[0], chartElements.candlestick.chart.data('candlestick'), '', candlestickOptions);

		    chartElements.rsi.label.removeClass('label-danger label-success label-default')
			    .addClass(insight['rsi']['label'])
			    .html(insight['rsi']['text']);
		    chartElements.rsi.chart.removeClass('danger success')
			    .addClass(insight['rsi']['chart']);
		    rsiChart.draw(chartElements.rsi.chart[0], chartElements.rsi.chart.data('rsi'), '', rsiOptions);


		    chartElements.macd.label.removeClass('label-danger label-success label-default')
			    .addClass(insight['macd']['label'])
			    .html(insight['macd']['text']);
		    chartElements.macd.chart.removeClass('danger success')
			    .addClass(insight['macd']['chart']);
		    macdChart.draw(chartElements.macd.chart[0], chartElements.macd.chart.data('macd'), '', macdOptions);

		    chartElements.stoch.label.removeClass('label-danger label-success label-default')
			    .addClass(insight['stoch']['label'])
			    .html(insight['stoch']['text']);
		    chartElements.stoch.chart.removeClass('danger success')
			    .addClass(insight['stoch']['chart']);
		    stochChart.draw(chartElements.stoch.chart[0], chartElements.stoch.chart.data('stoch'), '', stochOptions);
	    });
    </script>
@append