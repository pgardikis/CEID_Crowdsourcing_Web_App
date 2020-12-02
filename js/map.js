
/*---------- Heatmap -------------*/

let mymap = L.map('mapid',{drawControl: true})
let osmUrl='https://tile.openstreetmap.org/{z}/{x}/{y}.png';
let osmAttrib='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
let osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});
mymap.addLayer(osm);
mymap.setView([38.246242, 21.7350847], 16);

let cfg = {
  // radius should be small ONLY if scaleRadius is true (or small radius is intended)
  // if scaleRadius is false it will be the constant radius used in pixels
  "radius": 40,
  "maxOpacity": 0.8,
  // scales the radius based on map zoom
  "scaleRadius": false,
  // if set to false the heatmap uses the global maximum for colorization
  // if activated: uses the data maximum within the current map boundaries
  //   (there will always be a red spot with useLocalExtremas true)
  "useLocalExtrema": false,
  // which field name in your data represents the latitude - default "lat"
  latField: 'lat',
  // which field name in your data represents the longitude - default "lng"
  lngField: 'lng',
  // which field name in your data represents the data value - default "value"
  valueField: 'count'
};
var rect_count=0;
let heatmapLayer =  new HeatmapOverlay(cfg);
mymap.addLayer(heatmapLayer);
// FeatureGroup is to store editable layers
var drawnItems = new L.FeatureGroup();
mymap.addLayer(drawnItems);

mymap.on('draw:created', function (e) {
    var type = e.layerType,
        layer = e.layer;

    //  if (layer instanceof L.Rectangle) {
        /*layer.on('draw', function() {*/
          var x = layer.getLatLngs();

            console.log(x);
            /*console.log(layer.toGeoJSON().geometry.coordinates)*/
            var jsonString = JSON.stringify(x);

            
            puncte1=jsonString.toString();
            console.log(puncte1);
           
            
            var jsonString = JSON.stringify(puncte1);
            var puncte1 =puncte1.split(',');
            console.log(puncte1);
            puncte1=puncte1.join(',').match(/([\d\.]+)/g).join(',');
            console.log(puncte1);
            var puncte1 =puncte1.split(',');
            vertices_y = [],
            vertices_x = [];
            for (var i=0;i<puncte1.length;i++){
               if ((i+2)%2==0) {
               vertices_x.push(puncte1[i]);
            }
            else {
                vertices_y.push(puncte1[i]);
            }
            }
   $.ajax({
        type: "POST",
        url: "./uploadpage.php",
        data: {data : jsonString}, 
        cache: false,

        success: function(){
            
            $("#x").val(vertices_x);
            $("#y").val(vertices_y);
        }
    });

            rect_count=rect_count+1;
            console.log(rect_count);   
          
    drawnItems.addLayer(layer);
});


$(document).ready(function () {

 $("#btnExport").click(function (event) {

      //stop submit the form, we will post it manually.
      event.preventDefault();

      // Get form
      var form = $('#fileUploadForm')[0];

  // Create an FormData object 
      var data = new FormData(form);

  // disabled the submit button
      $("#btnExport").prop("disabled", true);

  $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "../admin/export.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function (response) {

              $("#result").text(data);
              console.log("SUCCESS : ", response);
              $("#btnExport").prop("disabled", false);

              var downloadLink = document.createElement("a");
              var fileData = ['\ufeff'+response];

              var blobObject = new Blob(fileData,{
                 type: "text/csv;charset=utf-8;"
               });

              var url = URL.createObjectURL(blobObject);
              downloadLink.href = url;
              downloadLink.download = "locationDataExport.csv";

              /*
               * Actually download CSV
               */
              document.body.appendChild(downloadLink);
              downloadLink.click();
              document.body.removeChild(downloadLink);
                
            },
            error: function (e) {

                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#btnExport").prop("disabled", false);

            }


           

        });
  });
  



    $("#btnSubmit").click(function (event) {

      //stop submit the form, we will post it manually.
      event.preventDefault();

      // Get form
      var form = $('#fileUploadForm')[0];

  // Create an FormData object 
      var data = new FormData(form);

  // disabled the submit button
      $("#btnSubmit").prop("disabled", true);

      $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "../get-data.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function (response) {

              $("#result").text(data);
              console.log("SUCCESS : ", response);
              $("#btnSubmit").prop("disabled", false);

              var data = JSON.parse(response)
              console.log(data);

              let testData = {
                max: 8,
                data:data};
              
              heatmapLayer.setData(testData);     
            },
            error: function (e) {

                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#btnSubmit").prop("disabled", false);

            }
        });
      $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "./get-data.php",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function (response) {

              $("#result").text(data);
              console.log("SUCCESS : ", response);
              $("#btnSubmit").prop("disabled", false);

              var data = JSON.parse(response)
              console.log(data);

              let testData = {
                max: 8,
                data:data};
              
              heatmapLayer.setData(testData);     
            },
            error: function (e) {

                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
                $("#btnSubmit").prop("disabled", false);

            }
        });


        $.ajax({
          type: "POST",
          url: "./user/queriea_graph.php",
          enctype: 'multipart/form-data',
          data: data,
          async: false,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(jsonData)
          {
            var data = JSON.parse(jsonData);
              console.log(data);
             var tdata = new google.visualization.DataTable();
             tdata.addColumn('string', "action");
             tdata.addColumn('number', "num");

             for (var i = 0; i < data.length; i++) {
                   tdata.addRow([data[i].joker, parseInt(data[i].num_of_records) ]);
             }
            
             var view = new google.visualization.DataView(tdata);
             view.setColumns([0, 1,
                                    { calc: "stringify",
                                      sourceColumn: 1,
                                      type: "string",
                                      role: "annotation" }]);
             var options = {
                 title: "Ποσοστό εγγραφών ανά είδος δραστηριότητας",
                 backgroundColor: '#fff',
                 width: 1000,
                 height: 300,
                 bar: {groupWidth: "65%"},
                 legend: { position: "none" }, };

                 var optionsa = {
                  title: "Ποσοστό εγγραφών ανά είδος δραστηριότητας",
                  backgroundColor: '#fff',
                  is3D: true,
                  width: 1000,
            
            };

            var chart = new google.visualization.PieChart(document.getElementById("erwthmaA"));
            chart.draw(view, optionsa);
          },
           error: function (e) {
               $("#result").text(e.responseText);
               console.log("LATHOSSSSS : ", e);
               $("#btnSubmit").prop("disabled", false);
              }
            }).responseText;


        $.ajax({
          type: "POST",
          url: "./user/querieb_graph.php",
          enctype: 'multipart/form-data',
          data: data,
          async: false,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(jsonData){
            var data = JSON.parse(jsonData);
            console.log(data);
            var tdata = new google.visualization.DataTable();
            tdata.addColumn('string', "action");
            tdata.addColumn('string', "hour");
            tdata.addColumn('number', "num");

            for (var i = 0; i < data.length; i++) {
              tdata.addRow([data[i].activity, data[i].tophour , parseInt(data[i].num_of_records) ]);
            }
            
            var view = new google.visualization.DataView(tdata);
            view.setColumns([0, 1, 2,
                                  { calc: "stringify",
                                      sourceColumn: 1,
                                      type: "string",
                                      role: "annotation" }]);

                 document.getElementById("qb").innerHTML = "'Ωρα της εβδομάδας με τις περισσότερες εγγραφές ανά είδος δραστηριότητας";
                  var table = new google.visualization.Table(document.getElementById("erwthmaB"));

                 table.draw(tdata, {showRowNumber: false, width: '90.4%', height: '20%'});
          },
          error: function (e) {
            $("#result").text(e.responseText);
            console.log("LATHOSSSSS : ", e);
            $("#btnSubmit").prop("disabled", false);

          }
          }).responseText;

          $.ajax({
            type: "POST",
            url: "./user/queriec_graph.php",
            enctype: 'multipart/form-data',
            data: data,
            async: false,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function(jsonData)
            {
              var data = JSON.parse(jsonData);
                console.log(data);
               var tdata = new google.visualization.DataTable();
               tdata.addColumn('string', "action");
               tdata.addColumn('string', "day");
               tdata.addColumn('number', "num");
               
               for (var i = 0; i < data.length; i++) {
                 tdata.addRow([data[i].activity, data[i].topday , parseInt(data[i].num_of_records) ]);
               }
              
           
               var view = new google.visualization.DataView(tdata);
               view.setColumns([0, 1, 2,
                                      { calc: "stringify",
                                        sourceColumn: 1,
                                        type: "string",
                                        role: "annotation" }]);
           
                   document.getElementById("qc").innerHTML = "Ημέρα της εβδομάδας με τις περισσότερες εγγραφές ανά είδος δραστηριότητας";
                    var table = new google.visualization.Table(document.getElementById("erwthmaC"));
                    
                   table.draw(tdata, {showRowNumber: false, width: '90.4%', height: '20%'});

            },
            error: function (e) {
              $("#result").text(e.responseText);
              console.log("LATHOSSSSS : ", e);
              $("#btnSubmit").prop("disabled", false);
            }
          }).responseText;
  });
});