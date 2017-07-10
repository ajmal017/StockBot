class GoogleChart {
    constructor(google, width = 350, height = 150) {
        this.google = google;
        this.width = width;
        this.height = height;
	    this.google.charts.load('current', {'packages':['corechart']});
    }
}