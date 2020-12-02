<?php
session_start();
require('./header.php');
include 'db.php';
include 'js/jquery_scripts.html';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Patras Hottest Spots</title>
  <link rel="stylesheet" href="css/main.css">
  <script src="js/main.js"></script>
</head>

<body>

<!-- Start of page -->
<div class="page">
<?php
    if (isset($_SESSION['nameuser']) ){
      require('./user/userIndex.php'); }
    else{
      echo ' 
      <div class="welcome-div"><h1>Make your own heatmap made for Patras city!</h1><img src="images/bg.jpg" id="bg" alt=""></div> ';
    }
?>
</div>
<!-- end of page -->

<footer>
  <div class="footer">
    <div class="container">
      <h1>Web 2020</h1>
      <p>Gardikis Panagiotis <br> Karamanis Dimitris <br> Tsalidis Andreas</p>
    </div>
  </div>
</footer>



<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}

var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}

$(document).ready(function() {
  $('select').niceSelect();
});
</script>
<script src="js/map.js"></script>
</body>
</html>