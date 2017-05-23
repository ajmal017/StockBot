@extends('base')

@section('content')
	<div id="summary">
		@foreach ($data['summary'] as $key => $item)
			<div class="panel panel-info">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-2 stock">
							<div class="stock-code">
								<a href="https://www.google.com/finance?q=IDX%3A{{ $key }}">
									<strong>IDX:{{ $key }}</strong>
								</a>
							</div>
							<div class="stock-price"><strong>{{ $item['price'] }}</strong></div>
							<div class="stock-change {{ $item['change'] >= 0 ? 'text-success' : 'text-danger' }}">
								{{ $item['change'] }} ({{ $item['percent'] }}%)
							</div>
						</div>
						<div class="col-sm-10 text-center">
							<div class="row">
								<div class="col-sm-4">
									<div>RSI</div>
									<div class="label label-success"></div>
									<div class="rsi-chart chart" data-chart="{{ $item['rsi'] }}"></div>
								</div>
								<div class="col-sm-4">
									<div>MACD</div>
									<div class="label label-danger"></div>
									<div class="macd-chart chart danger" data-chart="{{ $item['macd'] }}"></div>
								</div>
								<div class="col-sm-4">
									<div>STOCHASTIC</div>
									<div class="label label-warning"></div>
									<div class="stoch-chart chart success" data-chart="{{ $item['stochastic'] }}"></div>
								</div>
							</div>
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
        $(function() {
            let rsiChart = new RsiChart(google);
            let macdChart = new MacdChart(google);
            let stochChart = new StochChart(google);

            $('.rsi-chart').each(function(key, item) {
                let element = $(this);
                rsiChart.draw(element[0], element.data('chart'), '');
            });

            $('.macd-chart').each(function(key, item) {
                let element = $(this);
                macdChart.draw(element[0], element.data('chart'), '');
            });

            $('.stoch-chart').each(function(key, item) {
                let element = $(this);
                stochChart.draw(element[0], element.data('chart'), '');
            });
        });
	</script>
@append

@section('styles')
@append