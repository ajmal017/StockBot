@extends('base')

@section('styles')
	<link rel="stylesheet" href="{{ asset('css/progress-indicator.css') }}"/>
@append

@section('content')
	<div id="summary">
		@foreach ($data['summary'] as $key => $item)
			<div class="panel panel-info">
				<div class="panel-body text-center">
					<div class="row stock">
						<div class="col-sm-1">
							<a href="{{ route('stock', ['stockCode' => $item['stockCode']]) }}">{{ $item['stockCode'] }}</a>
						</div>
						<div class="col-sm-2 text-right">
							<strong>{{ $item['price'] }}</strong>
						</div>
						<div class="col-sm-2 text-left">
							<span class="{{ $item['change'] >= 0 ? 'text-success' : 'text-danger' }}">{{ $item['change'] }} ({{ $item['percent'] }}%)</span>
						</div>
						<div class="col-sm-6">
							<ul class="progress-indicator">
								<li class="sell {{ ($item['overall'] <= -3) ? 'danger' : '' }}"><span class="bubble"></span>SELL NOW!</li>
								<li class="sell {{ ($item['overall'] <= -2) ? 'danger' : '' }}"><span class="bubble"></span>SELL</li>
								<li class="hold {{ ($item['overall'] < 0) ? 'danger' : (($item['overall'] > 0) ? 'completed' : '') }}"><span class="bubble"></span>HOLD</li>
								<li class="buy {{ ($item['overall'] >= 2) ? 'completed' : '' }}"><span class="bubble"></span>BUY</li>
								<li class="buy {{ ($item['overall'] >= 3) ? 'completed' : '' }}"><span class="bubble"></span>BUY NOW!</li>
							</ul>
						</div>
						<div class="col-sm-1">
							<button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapseExample">
								<i class="glyphicon glyphicon-plus"></i>
							</button>
						</div>
					</div>
					<div class="row chart-detail collapse" id="collapse-{{ $key }}">
						<div class="col-sm-4">
							<div>
								RSI <span class="label {{ $item['insight']['rsi']['label'] }}">{{ $item['insight']['rsi']['text'] }}</span>
							</div>
							<div class="rsi-chart chart {{ $item['insight']['rsi']['chart'] }}" data-chart="{{ $item['rsi'] }}"></div>
						</div>
						<div class="col-sm-4">
							<div>
								MACD <span class="label {{ $item['insight']['macd']['label'] }}">{{ $item['insight']['macd']['text'] }}</span>
							</div>
							<div class="macd-chart chart {{ $item['insight']['macd']['chart'] }}" data-chart="{{ $item['macd'] }}"></div>
						</div>
						<div class="col-sm-4">
							<div>
								STOCHASTIC <span class="label {{ $item['insight']['stoch']['label'] }}">{{ $item['insight']['stoch']['text'] }}</span>
							</div>
							<div class="stoch-chart chart {{ $item['insight']['stoch']['chart'] }}" data-chart="{{ $item['stoch'] }}"></div>
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

	<script>
		let rsiOptions = {
			curveType: 'none',
			legend: 'none',
			vAxis: {
				maxValue: 100,
				minValue: 0
			},
			hAxis: {
				textPosition: 'none'
			}
		};
		let macdOptions = {
			legend: 'none',
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
			legend: 'none',
			vAxis: {
				maxValue: 100,
				minValue: 0
			},
			hAxis: {
				textPosition: 'none'
			}
		};

		$(function () {
			let rsiChart = new RsiChart(google);
			let macdChart = new MacdChart(google);
			let stochChart = new StochChart(google);

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