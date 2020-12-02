<?php 
session_start();
include '../db.php';
include '../js/jquery_scripts.html';
  if(!isset($_SESSION['adminId']))
  {
      header('Location: ../index.php?error=malicious');
      exit();
  }  ?>
<!DOCclass html>
<html>
<head>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css_admin/admin_main.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="../js/graph.js"></script>
<script src="../js/table.js"></script>
</head>
<body>

<ul><form action="./newindex.php">
  <li><a class="active" href="./newindex.php">Admin</a></li></form>
  <li><a href="index.php">Heatmap</a></li>
  <li><a href="#Heatmap" id="dkjash" class="clickMe">Delete all data</a></li>
  <li><a href="#Heatmap">About</a></li>
</ul>

<h1 style="margin-left:10%"></h1>
<div style="margin-left:25%;padding:1px 16px;height:1000px;">
  <form action="./newindex.php">
    <button type="sumbit" class="btn"><i class="fa fa-home"></i></button>
  </form>
<div>
  <a href="delete.php">
    <button class="button" id="deleteButton" onclick="alert1()"><h3>Delete location data!</h3></button>
  </a>
</div>

  <div class="wrapper">

    <div class="one">
      <button class="button" onmouseover="openCity(event, 'qA', 'querieA', 'graphA', 'pieA', 'activity', 'records', 'Ποσοστό εγγραφών ανά τύπο δραστηριότητας')">Δραστηριότητες</button>
    </div>
    <div class="two">
      <button class="button" onmouseover="openCity(event, 'qB', 'querieB', 'graphB', 'pieB',  'user', 'records', 'Εγγραφές ανά χρήστη')">Εγγραφές ανά χρήστη</button>
    </div>

    <div class="three">
      <button class="button" onmouseover="openCity(event, 'qC', 'querieC', 'graphC', 'pieC',  'month', 'records', 'Εγγραφές ανά μήνα')">Εγγραφές ανά μήνα</button>
    </div>

    <div class="four">
      <button class="button" onmouseover="openCity(event, 'qD', 'querieD', 'graphD', 'pieD',  'day', 'records', 'Εγγραφές ανά ημέρα')">Εγγραφές ανά ημέρα</button>
    </div>

    <div class="five">
      <button class="button" onmouseover="openCity(event, 'qE', 'querieE', 'graphE', 'pieE',  'hour', 'records', 'Εγγραφές ανά ώρα')">Εγγραφές ανά ώρα</button>
    </div>

    <div class="six">
      <button class="button" onmouseover="openCity(event, 'qF', 'querieF', 'graphF', 'pieF',  'year', 'records', 'Εγγραφές ανά χρονολογία')">Εγγραφές ανά χρονολογία</button>
    </div>
  </div> <!-- end wrapper -->




  <div id="qA" class="tabcontent">
    <!-- <div class="wrapper"> -->
      <div class="one">
        <p id="querieA"></p>
      </div>
      <div class="left_bar">
      <p id="graphA"></p>
      </div>
      <div class="left_bar">
      <p id="pieA" style="width: 900px; height: 500px;"></p>
      </div>
    <!-- </div> -->
  </div>

  <div id="qB" class="tabcontent">
    <!-- <div class="wrapper"> -->
      <div class="one">
        <p id="querieB"></p>
      </div>
      <div class="left_bar">
      <p id="graphB"></p>
      </div>
      <div class="left_bar">
      <p id="pieB" style="width: 900px; height: 500px;"></p>
      </div>
    <!-- </div> -->
  </div>

  <div id="qC" class="tabcontent">
    <!-- <div class="wrapper"> -->
      <div class="one">
        <p id="querieC"></p>
      </div>
      <div class="left_bar">
      <p id="graphC"></p>
      </div>
      <div class="left_bar">
      <p id="pieC" style="width: 900px; height: 500px;"></p>
      </div>
    <!-- </div> -->
  </div>

  <div id="qD" class="tabcontent">
    <!-- <div class="wrapper"> -->
      <div class="one">
        <p id="querieD"></p>
      </div>
      <div class="left_bar">
      <p id="graphD"></p>
      </div>
      <div class="left_bar">
      <p id="pieD" style="width: 900px; height: 500px;"></p>
      </div>
    <!-- </div> -->
  </div>

  <div id="qE" class="tabcontent">
    <!-- <div class="wrapper"> -->
      <div class="one">
        <p id="querieE"></p>
      </div>
      <div class="left_bar">
      <p id="graphE"></p>
      </div>
      <div class="left_bar">
      <p id="pieE" style="width: 900px; height: 500px;"></p>
      </div>
    <!-- </div> -->
  </div>

  <div id="qF" class="tabcontent">
    <!-- <div class="wrapper"> -->
      <div class="one">
        <p id="querieF"></p>
      </div>
      <div class="left_bar">
      <p id="graphF"></p>
      </div>
      <div class="left_bar">
      <p id="pieF" style="width: 900px; height: 500px;"></p>
      </div>
    <!-- </div> -->
  </div>

</div>

  <script>

function openCity(evt, cityName, qID, grID, pie, action, rec, title) {

  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  graph_chart(qID, grID, pie, action, rec, title);
  evt.currentTarget.className += " active";

}

$('.clickMe').click(function(){
    alert("Be careful! you are about to delete ALL location data from database!");
    var x = document.querySelectorAll(".wrapper, .tabcontent");
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = 'none';
    }
    document.getElementById("deleteButton").style.display = "block";
});

function alert1(){
  alert("Last chance! You are going to delete your whole database!");
}   

</script>

</body>


</html>
