class StockList {
	constructor(selector, gChart) {
		this.app = new Vue({
			el: selector,
			data: {
				stocks: []
			},
			methods: {
				generateStock: function() {
					this.$http.get('http://localhost:8000/api/watchedStock').then((response) => {
						let data = response.body;
						data.forEach(function(item, index) {
							this.$http.get('http://localhost:8000/api/stock/' + item.stockCode + '/summary').then((response) => {
								this.stocks.push(response.body);
							}, this);
						}, this);
					});
				}
			}
		});
	}
}