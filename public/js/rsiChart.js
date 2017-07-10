class RsiChart extends GoogleChart {
    draw(element, param, title, options) {
        this.google.charts.setOnLoadCallback(() => {
            options = {
                title: title,
                width: this.width,
	            height: this.height,
                curveType: options.curveType,
                legend: options.legend,
                vAxis: options.vAxis,
                hAxis: options.hAxis
            };
            let data = this.google.visualization.arrayToDataTable(param);
            let chart = new this.google.visualization.LineChart(element);
            chart.draw(data, options);
        });
    }
}