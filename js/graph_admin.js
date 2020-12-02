google.charts.load('current', {'packages':['corechart', 'table']});
 
function graph_chart(erwthma, num, ttle) {
 
 var jsonData = $.ajax({
 url: "queries_graph.php?querie="+ erwthma,
 dataType:"json",
 async: false,
 success: function(jsonData)
 {
	var tdata = new google.visualization.DataTable();
	tdata.addColumn('string', action);
	tdata.addColumn('number', num);

	for (var i = 0; i < jsonData.length; i++) {
	  	tdata.addRow([jsonData[i].joker, parseInt(jsonData[i].number_of_records) ]);
	}
	console.log(tdata);

	var view = new google.visualization.DataView(tdata);
	view.setColumns([0, 1,
			               { calc: "stringify",
			                 sourceColumn: 1,
			                 type: "string",
			                 role: "annotation" }]);
    var options = {
		title: ttle,
		backgroundColor: '#ddd',
	    width: 1000,
	    height: 300,
	    bar: {groupWidth: "65%"},
		legend: { position: "none" }, };
		

		var optionsa = {
			title: ttle,
			backgroundColor: '#ddd',
			width: 1000,

};

    var chart = new google.visualization.ColumnChart(document.getElementById(graph));
	chart.draw(view, options);

	var chart = new google.visualization.PieChart(document.getElementById(pie));
	chart.draw(view, optionsa);
	
	var table = new google.visualization.Table(document.getElementById(erwthma));

        table.draw(tdata, {showRowNumber: false, width: '90.4%', height: '20%'});
  }

 

 }).responseText;
}