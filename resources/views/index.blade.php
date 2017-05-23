@extends('base')

@section('content')
    <div id="summary">
        @foreach ($data['summary'] as $key => $item)
            <div class="panel panel-info">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12 stock text-center">
                            <div class="stock-code">
                                <a href="{{ route('stock', ['stockCode' => $key]) }}">{{ $key }}</a>
                            </div>
                            <div>
                                <span class="stock-price"><strong>{{ $item['price'] }}</strong></span>
                                <span class="stock-change {{ $item['change'] >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $item['change'] }} ({{ $item['percent'] }}%)
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="col-sm-4">
                            <div>
                                RSI
                                <span class="label {{ $item['insight']['rsi']['label'] }}">
											{{ $item['insight']['rsi']['text'] }}
										</span>
                            </div>
                            <div class="rsi-chart chart {{ $item['insight']['rsi']['chart'] }}"
                                 data-chart="{{ $item['rsi'] }}"></div>
                        </div>
                        <div class="col-sm-4">
                            <div>
                                MACD
                                <span class="label {{ $item['insight']['macd']['label'] }}">
											{{ $item['insight']['macd']['text'] }}
										</span>
                            </div>
                            <div class="macd-chart chart {{ $item['insight']['macd']['chart'] }}"
                                 data-chart="{{ $item['macd'] }}"></div>
                        </div>
                        <div class="col-sm-4">
                            <div>
                                STOCHASTIC
                                <span class="label {{ $item['insight']['stoch']['label'] }}">
											{{ $item['insight']['stoch']['text'] }}
										</span>
                            </div>
                            <div class="stoch-chart chart {{ $item['insight']['stoch']['chart'] }}"
                                 data-chart="{{ $item['stoch'] }}"></div>
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
        $(function () {
            let rsiChart = new RsiChart(google);
            let macdChart = new MacdChart(google);
            let stochChart = new StochChart(google);

            $('.rsi-chart').each(function (key, item) {
                let element = $(this);
                rsiChart.draw(element[0], element.data('chart'), '');
            });

            $('.macd-chart').each(function (key, item) {
                let element = $(this);
                macdChart.draw(element[0], element.data('chart'), '');
            });

            $('.stoch-chart').each(function (key, item) {
                let element = $(this);
                stochChart.draw(element[0], element.data('chart'), '');
            });
        });
    </script>
@append