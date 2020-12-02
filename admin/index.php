
<?php
session_start();
require('../header.php');
include '../db.php';
include '../js/jquery_scripts.html';


// Prevent users from navigating to admin page without beeing logged in as Admin
if(!isset($_SESSION['adminId']))
{
    header('Location: ../index.php?error=malicious');
    exit();
} 

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patras Hottest Spots</title>
    <link rel="stylesheet" href="../css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../js/main.js"></script>

</head>
<body>


<div id="main">
  <div class="main-content container">
  <div id="mySidebar" class="sidebar" >
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <form method="POST" enctype="multipart/form-data" id="fileUploadForm">
        <div>
              <a>
                <h3 for="y1">Year from: </h3>
                <select class="nice-select1" name="y1">
                  <option data-display="2014" value='2014'>2014</option>
                  <option value='2015'>2015</option>
                  <option value='2016'>2016</option>
                  <option value='2017'>2017</option>
                  <option value='2018'>2018</option>
                  <option value='2019'>2019</option>
                  <option value='2020'>2020</option>
                  <option value='2021'>2021</option>
                </select> </a>
              
              <a>
                <h3 for="y2">Year to: </h3>
                <select class="nice-select1" name="y2" s>
                  <option data-display="2014" value='2014'>2014</option>
                  <option value='2015'>2015</option>
                  <option value='2016'>2016</option>
                  <option value='2017'>2017</option>
                  <option value='2018'>2018</option>
                  <option value='2019'>2019</option>
                  <option value='2020'>2020</option>
                  <option value='2021'>2021</option>
                </select>
              </a>
              <a>
                <h3 for="m1">Month from: </h3>
                <select class="nice-select1" name="m1">
                  <option data-display="Ιανουάριος" value='1'>Ιανουάριος</option>
                  <option value='2'>Φεβρουάριος</option>
                  <option value='3'>Μάρτιος</option>
                  <option value='4'>Απρίλιος</option>
                  <option value='5'>Μάιος</option>
                  <option value='6'>Ιούνιος</option>
                  <option value='7'>Ιούλιος</option>
                  <option value='8'>Αύγουστος</option>
                  <option value='9'>Σεπτέμβριος</option>
                  <option value='10'>Οκτώβριος</option>
                  <option value='11'>Νοέμβριος</option>
                  <option value='12'>Δεκέμβριος</option>
                </select>
              </a>
              <a>
                <h3 for="m2">Month to: </h3>
                <select class="nice-select1"  name="m2">
                  <option data-display="Ιανουάριος" value='1'>Ιανουάριος</option>
                  <option value='2'>Φεβρουάριος</option>
                  <option value='3'>Μάρτιος</option>
                  <option value='4'>Απρίλιος</option>
                  <option value='5'>Μάιος</option>
                  <option value='6'>Ιούνιος</option>
                  <option value='7'>Ιούλιος</option>
                  <option value='8'>Αύγουστος</option>
                  <option value='9'>Σεπτέμβριος</option>
                  <option value='10'>Οκτώβριος</option>
                  <option value='11'>Νοέμβριος</option>
                  <option value='12'>Δεκέμβριος</option>
                </select>
              </a>
              <a>
                <h3 for="d1">Day from: </h3>
                <select class="nice-select1" name="d1">
                  <option data-display="Δευτέρα" value='1'>Δευτέρα</option>
                  <option value='2'>Τρίτη</option>
                  <option value='3'>Τετάρτη</option>
                  <option value='4'>Πέμπτη</option>
                  <option value='5'>Παρασκευή</option>
                  <option value='6'>Σάββατο</option>
                  <option value='7'>Κυριακή</option>  
                </select>
              </a>
              <a>
                <h3 for="d2">Day to: </h3>
                <select class="nice-select1" name="d2">
                  <option data-display="Δευτέρα" value='1'>Δευτέρα</option>
                  <option value='2'>Τρίτη</option>
                  <option value='3'>Τετάρτη</option>
                  <option value='4'>Πέμπτη</option>
                  <option value='5'>Παρασκευή</option>
                  <option value='6'>Σάββατο</option>
                  <option value='7'>Κυριακή</option>  
                </select>
              </a>
              <a>
                <h3 for="t1">Time from: </h3>
                <select class="nice-select1" name="t1">
                  <option data-display="01"value='01'>01</option>
                  <option value='02'>02</option>
                  <option value='03'>03</option>
                  <option value='04'>04</option>
                  <option value='05'>05</option>
                  <option value='06'>06</option>
                  <option value='07'>07</option>
                  <option value='08'>08</option>
                  <option value='09'>09</option>
                  <option value='10'>10</option>
                  <option value='11'>11</option>
                  <option value='12'>12</option>
                  <option value='13'>13</option>
                  <option value='14'>14</option>
                  <option value='15'>15</option>
                  <option value='16'>16</option>
                  <option value='17'>17</option>
                  <option value='18'>18</option>
                  <option value='19'>19</option>  
                  <option value='20'>20</option>
                  <option value='21'>21</option>
                  <option value='22'>22</option>
                  <option value='23'>23</option>
                  <option value='24'>24</option> 
                </select>
              </a>
              <a>
                <h3 for="t2">Time to: </h3>
                <select class="nice-select1" name="t2">
                  <option data-display="01" value='01'>01</option>
                  <option value='02'>02</option>
                  <option value='03'>03</option>
                  <option value='04'>04</option>
                  <option value='05'>05</option>
                  <option value='06'>06</option>
                  <option value='07'>07</option>
                  <option value='08'>08</option>
                  <option value='09'>09</option>
                  <option value='10'>10</option>
                  <option value='11'>11</option>
                  <option value='12'>12</option>
                  <option value='13'>13</option>
                  <option value='14'>14</option>
                  <option value='15'>15</option>
                  <option value='16'>16</option>
                  <option value='17'>17</option>
                  <option value='18'>18</option>
                  <option value='19'>19</option>  
                  <option value='20'>20</option>
                  <option value='21'>21</option>
                  <option value='22'>22</option>
                  <option value='23'>23</option>
                  <option value='24'>24</option> 
                </select>
              </a>


              <h1 style="margin-top:60px;">Activity:</h1> <a>
              <label class="checkContainer">Check/Uncheck All 
                <input type="checkbox" onClick="toggle(this)">  
                <span class="checkmark"></span> </label> 
              <label class="checkContainer">Walking 
                <input type='hidden' value='null' name='w'>
                <input type="checkbox" checked="checked" class="checkbox" name="w" value="'WALKING'"> 
                <span class="checkmark"></span> </label> 
              <label class="checkContainer">On bicycle 
                <input type='hidden' value='null' name='b'>
                <input type="checkbox" checked="checked" class="checkbox" name="b" value="'ON_BICYCLE'"> 
                <span class="checkmark"></span> </label> 
              <label class="checkContainer">Still <input type='hidden' value='null' name='s'>
                <input type="checkbox"  checked="checked" class="checkbox" name="s" value="'STILL'"> 
                <span class="checkmark"></span> </label> 
              <label class="checkContainer">Tilting <input type='hidden' value='null' name='t'>
                <input type="checkbox"  checked="checked" class="checkbox" name="t" value="'TILTING'"> 
                <span class="checkmark"></span> </label> 
              <label class="checkContainer" >In vehicle 
                <input type='hidden' value='null' name='iv'> 
                <input type="checkbox" checked="checked" class="checkbox" name="iv" value="'IN_VEHICLE'"> 
                <span class="checkmark"></span> </label> 
              <label class="checkContainer" >Exiting vehicle 
                <input type='hidden' value='null' name='ev'> 
                <input type="checkbox" checked="checked" class="checkbox" name="ev" value="'EXITING_VEHICLE'"> 
                <span class="checkmark"></span> </label> 
              <label  class="checkContainer" >Unknown 
                <input type='hidden' value='null' name='u'>
                <input type="checkbox" checked="checked" class="checkbox" name="u" value="'UNKNOWN'"> 
                <span class="checkmark"></span> </label> </a> </div>
              <button type="submit" id="btnSubmit" class="btn-submit" name="searchMap">Search heatmap</button> 
              <h1 style="margin-top:60px;">Export Data:</h1> <a>
              <button type="submit" id="btnExport" class="btn-submit" name="searchMap" >Export CSV</button>
        </form> 
      </div> 

        <div class="main-content-div"> 
          <button class="openbtn" onclick="openNav()">☰ Pick year and month range</button>   
        </div>

<div class="main-content-div">
        <div class="userDashboard">
          <button type="button" class="collapsible">
          <a href="newindex.php" style="color: white">Dashboard</a>
        </button>
        </div>
</div>      
  <div class="map">
    <div class="map-content container">
      <?php echo '<div id="mapid"></div>'; ?>
    </div>
  </div>
</div>
</div>
</body>
<script src="../js/map.js"></script> <!--  AN DEN EINAI STO TELOS DEN KALEITAI O XARTHS SWSTA -->
</html>