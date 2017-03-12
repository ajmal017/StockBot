class GoogleChart {
	constructor(google) {
		this.google = google;
	}

	drawCandlestickChart(param, title, element) {
		this.google.charts.load('current', {'packages':['corechart']});
		this.google.charts.setOnLoadCallback(() => {
			let data = this.parseData(param);
			let options = {
				title: title,
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
				height: 300
			};
			let chart = new this.google.visualization.CandlestickChart(element);
			chart.draw(data, options);
		});
	}

	parseCandlestickData(param) {
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
			curr.push(curr[0].toDateString() + "\nClose: " + curr[3]);
		}

		results.addRows(param);

		return results;
	}
}