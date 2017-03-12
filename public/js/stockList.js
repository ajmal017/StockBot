class StockChart {
	constructor(selector, gChart) {
		this.app = new Vue({
			el: selector,
			data: {
				stockCodes: [],
				stockDatas: [],
				gChart: gChart
			},
			methods: {
				getStockData: function(stockCode) {
					this.$http.get('http://localhost:8000/api/stock/' + stockCode + '/chart').then((response) => {
						this.gChart.drawChart(response.body, stockCode, this.$el);
					});
				}
			}
		});
	}
}