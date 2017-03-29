Vue.component('stock', {
	template: '<div class="panel panel-info">' +
		'<div class="panel-body">' +
		'<div class="row">' +
		'<div class="col-sm-3"><div class="stock-code">{{ stockCode }}</div><div class="stock-price">{{ stockPrice }}</div></div>' +
		'<div class="col-sm-3"><div>RSI</div><div class="label label-success"></div><div :id="stockCode + \'-rsi\'"></div></div>' +
		'<div class="col-sm-3"><div>MACD</div><div class="label label-danger"></div><div :id="stockCode + \'-rsi\'"></div></div>' +
		'<div class="col-sm-3"><div>STOCHASTIC</div><div class="label label-warning"></div><div :id="stockCode + \'-rsi\'"></div></div>' +
		'</div>' +
		'</div>' +
		'</div>',
	props: ['stockCode', 'stockPrice']
});