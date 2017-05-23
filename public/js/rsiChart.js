class RsiChart extends GoogleChart {
    draw(element, param, title) {
        this.google.charts.load('current', {'packages':['corechart']});
        this.google.charts.setOnLoadCallback(() => {
            let options = {
                title: title,
                curveType: 'none',
                legend: 'none',
                lineWidth: 1,
                vAxis: {
                    maxValue: 100,
                    minValue: 0
                },
                hAxis: {
                    textPosition: 'none'
                },
                height: 150
            };
            let data = this.google.visualization.arrayToDataTable(param);
            let chart = new this.google.visualization.LineChart(element);
            chart.draw(data, options);
        });
    }
}