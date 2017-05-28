@extends('base')

@section('content')
	<div id="detail">
		<div class="panel panel-info">
			<div class="panel-body text-center">
				<div class="row">
					<div class="col-sm-12 stock">
						<div class="stock-code">
							{{ $data['details']['stockCode'] }}
						</div>
						<div>
							<span class="stock-price"><strong>{{ $data['details']['price'] }}</strong></span>
							<span class="stock-change {{ $data['details']['change'] >= 0 ? 'text-success' : 'text-danger' }}">{{ $data['details']['change'] }} ({{ $data['details']['percent'] }}%)</span>
						</div>
						<div class="candlestick-chart chart" data-chart="{{ $data['details']['historicPrices'] }}"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div>
							RSI <span class="label {{ $data['details']['insight']['rsi']['label'] }}">{{ $data['details']['insight']['rsi']['text'] }}</span>
						</div>
						<div class="rsi-chart chart {{ $data['details']['insight']['rsi']['chart'] }}" data-chart="{{ $data['details']['rsi'] }}"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div>
							MACD <span class="label {{ $data['details']['insight']['macd']['label'] }}">{{ $data['details']['insight']['macd']['text'] }}</span>
						</div>
						<div class="macd-chart chart {{ $data['details']['insight']['macd']['chart'] }}" data-chart="{{ $data['details']['macd'] }}"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div>
							STOCHASTIC <span class="label {{ $data['details']['insight']['stoch']['label'] }}">{{ $data['details']['insight']['stoch']['text'] }}</span>
						</div>
						<div class="stoch-chart chart {{ $data['details']['insight']['stoch']['chart'] }}" data-chart="{{ $data['details']['stoch'] }}"></div>
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

    <script>
	    let rsiOptions = {
		    curveType: 'none',
		    legend: 'bottom',
		    vAxis: {
			    maxValue: 100,
			    minValue: 0
		    },
		    hAxis: {
			    textPosition: 'none'
		    }
	    };
	    let macdOptions = {
		    legend: 'bottom',
		    seriesType: 'line',
		    series: { 2: { type: 'bars' } },
		    colors: ['blue', 'red', 'grey'],
		    bar: {
			    groupWidth: '80%'
		    },
		    vAxis: {
			    maxValue: 0.25,
			    minValue: -0.25
		    },
		    hAxis: {
			    textPosition: 'none'
		    }
	    };
	    let stochOptions = {
		    curveType: 'none',
		    legend: 'bottom',
		    vAxis: {
			    maxValue: 100,
			    minValue: 0
		    },
		    hAxis: {
		    	textPosition: 'none'
		    }
	    };
	    let candlestickOptions = {
		    legend: 'none',
		    candlestick: {
			    fallingColor: {
				    strokeWidth: 0,
				    fill: '#ff4136',
			    },
			    risingColor: {
				    strokeWidth: 0,
				    fill: '#28b62c',
			    }
		    },
		    bar: {
			    groupWidth: '80%'
		    },
		    series: {
			    0: {color: 'black'}
		    }
	    };

	    $(function() {
		    let candlestickChart = new CandlestickChart(google, 300);
		    let rsiChart = new RsiChart(google, 300);
		    let macdChart = new MacdChart(google, 300);
		    let stochChart = new StochChart(google, 300);

		    $('.candlestick-chart').each(function() {
			    let element = $(this);
			    candlestickChart.draw(element[0], element.data('chart'), '', candlestickOptions);
		    });

		    $('.rsi-chart').each(function () {
			    let element = $(this);
			    rsiChart.draw(element[0], element.data('chart'), '', rsiOptions);
		    });

		    $('.macd-chart').each(function () {
			    let element = $(this);
			    macdChart.draw(element[0], element.data('chart'), '', macdOptions);
		    });

		    $('.stoch-chart').each(function () {
			    let element = $(this);
			    stochChart.draw(element[0], element.data('chart'), '', stochOptions);
		    });
	    });
    </script>
@append