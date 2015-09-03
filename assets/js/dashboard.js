
// Ensure the document is ready
$(document).ready(function() {


	/* ********** Dashboard Charts ********** */

	// See 'http://www.chartjs.org/docs/' for details
	var chartOptions = {
		animation: true,
		animationSteps : 60,
		animationEasing : "easeOutQuart",
		animateRotate : true,
		animateScale : true,
		responsive : true,
		segmentShowStroke : true,
		segmentStrokeColor : "#fff",
		segmentStrokeWidth : 2,
		percentageInnerCutout : 50,
		legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span><span style=\"border:5px solid <%=segments[i].fillColor%>\"></span></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
	};

	// Get data from server
	$.getJSON('/dashboard/charts', function(chartData) {

		// Draw the charts
		var ctx1 = $("#dashboard-chart-1").get(0).getContext("2d");
		window.myDoughnut1 = new Chart(ctx1).Doughnut(chartData['chart1'], chartOptions);

		var ctx2 = $("#dashboard-chart-2").get(0).getContext("2d");
		window.myDoughnut2 = new Chart(ctx2).Doughnut(chartData['chart2'], chartOptions);

		var ctx3 = $("#dashboard-chart-3").get(0).getContext("2d");
		window.myDoughnut3 = new Chart(ctx3).Doughnut(chartData['chart3'], chartOptions);

		// Add chart ledgends
		$('<div></div>')
			.html(myDoughnut1.generateLegend())
			.insertAfter('#dashboard-chart-1');

		$('<div></div>')
			.html(myDoughnut2.generateLegend())
			.insertAfter('#dashboard-chart-2');

		$('<div></div>')
			.html(myDoughnut3.generateLegend())
			.insertAfter('#dashboard-chart-3');
	});



    /* ********** Dashboard Questionnaires Table ********** */

	// Stores the highest retrned date
	var maxReturned = 0;

	// See 'http://datatables.net/reference/' for details
	var mytable = $('#questionnaires-table').dataTable({
		"columns": [
		    {
		    	"name": "company_name",
		    	"type": "html"
		    },
		    {
		    	"name": "project_type",
		    	"type": "string"
		    },
		    {
		    	"name": "issued",
		    	"type": "date"
		    },
		    {
		    	"name": "progress",
		    	"type": "numeric-fmt",
		    	"render" : function(data, type, row, meta) {
		    		if (type === 'sort') {
		    			return parseInt($(data).text());
		    		}

		    		return data;
		    	}
		    },
		    {
		    	"name": "returned",
		    	"type": "date"
		    }
		]
	});



    /* ********** Dashboard Questionnaires Table Peity Charts ********** */

	// Override defaults
	$.fn.peity.defaults.pie = {
		delimiter: "/",
		diameter: 16,
		fill: ["#46bfbd", "#d7d7d7"],
		height: null,
		width: null
	}

	// Plot charts
	$('span.pie').peity('pie');

	// When the table is re-drawn, draw any charts that wern't previously visible
	$('#questionnaires-table').on('draw.dt', function() {

		$('span.pie').peity('pie');
	});


});
