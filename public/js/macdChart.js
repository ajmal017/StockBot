class MacdChart extends GoogleChart {
    draw(element, param, title) {
        this.google.charts.load('current', {'packages':['corechart']});
        this.google.charts.setOnLoadCallback(() => {
            let options = {
                title: title,
                legend: 'none',
                seriesType: 'line',
                series: { 2: { type: 'bars' } },
                lineWidth: 1,
                bar: {
                    groupWidth: '90%'
                },
                vAxis: {
                    maxValue: 0.25,
                    minValue: -0.25
                },
                hAxis: {
                    textPosition: 'none'
                },
                height: 150
            };
            let data = this.google.visualization.arrayToDataTable(param);
            let chart = new this.google.visualization.ComboChart(element);
            chart.draw(data, options);
        });
    }
}