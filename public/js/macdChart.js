class MacdChart extends GoogleChart {
    draw(element, param, title, options) {
        this.google.charts.setOnLoadCallback(() => {
            options = {
                title: title,
	            width: this.width,
	            height: this.height,
                legend: options.legend,
                seriesType: options.seriesType,
                series: options.series,
                colors: options.colors,
                bar: options.bar,
                vAxis: options.vAxis,
                hAxis: options.hAxis
            };
            let data = this.google.visualization.arrayToDataTable(param);
            let chart = new this.google.visualization.ComboChart(element);
            chart.draw(data, options);
        });
    }
}