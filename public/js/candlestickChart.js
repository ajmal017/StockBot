class CandlestickChart extends GoogleChart {
	draw(element, param, title, options) {
		this.google.charts.load('current', {'packages':['corechart']});
		this.google.charts.setOnLoadCallback(() => {
			let data = this.parse(param);
			options = {
				title: title,
				width: this.width,
				height: this.height,
				legend: options.legend,
				candlestick: options.candlestick,
				bar: options.bar,
				series: options.series
			};
			let chart = new this.google.visualization.CandlestickChart(element);
			chart.draw(data, options);
		});
	}

	parse(param) {
		let results = new this.google.visualization.DataTable();

		results.addColumn('date', 'Date');
		results.addColumn('number');
		results.addColumn('number');
		results.addColumn('number');
		results.addColumn('number');
		results.addColumn({type:'string',role:'tooltip'});

		for (let i = 0; i < param.length; i++) {
			let curr = param[i];

			curr[0] = new Date(curr[0]);
			curr.push(curr[0].toDateString() + "\nLow: " + curr[1] + " - High: " + curr[4] + "\nOpen: " + curr[2] + " - Close: " + curr[3]);
		}

		results.addRows(param);

		return results;
	}
}