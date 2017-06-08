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