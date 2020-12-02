
<!-------------- Start of main -------------->
<div id="main">
  <div class="main-content container">
    <div id="mySidebar" class="sidebar" >
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
      <form method="POST" enctype="multipart/form-data" id="fileUploadForm">
      <div>
          <h1>Περίοδος ετών:</h1>
            <a>
              <h3 for="y1">Year from: </h3>
              <select name="y1">
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
              <select name="y2" s>
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
          <h1 style="margin-top:60px;">Περίοδος μηνών:</h1>
            <a>
              <h3 for="m1">Month from: </h3>
              <select name="m1">
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
              <select name="m2">
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

            <h1 style="margin-top:60px;">Επιλογή δραστηριότητας:</h1> <a>
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
            <button type="submit" id="btnSubmit" class="btn-submit" name="searchMap">search</button> 
      </form> 
    </div> 


<!-------------- Start of user Analyse --------------> 
        <div class="main-content-div"> 
          <button class="openbtn" onclick="openNav()">☰ Pick year and month range</button>   
        </div>
<!-------------- End of user Analyse -------------->


<!-------------- Start of user Dashboard -------------->
  <div class="main-content-div">
    <?php
    if (isset($_SESSION['nameuser']) and !isset($_SESSION['adminId'])) {
          
      $query="SELECT to_char(act_timestamp, 'YYYY-MM') AS month, round(COUNT(*) * 100.0 / (SELECT COUNT(*) 
              FROM activitydata INNER JOIN locationdata ON loc_id=location_id
              WHERE uploader='$_SESSION[userId]'
              AND (act_timestamp  BETWEEN date_trunc('month', CURRENT_DATE) - INTERVAL '12 months' AND date_trunc('month', CURRENT_DATE) - INTERVAL '1 months') ), 2) 
              AS score
              FROM activitydata INNER JOIN locationdata ON loc_id=location_id
              WHERE uploader='$_SESSION[userId]'
              AND (act_timestamp  BETWEEN date_trunc('month', CURRENT_DATE) - INTERVAL '12 months' AND date_trunc('month', CURRENT_DATE) - INTERVAL '1 months') 
              AND (type='ON_FOOT' OR type='RUNNING' OR type='WALKING' OR type='STILL' )
              GROUP BY to_char(act_timestamp, 'YYYY-MM')
              ORDER BY 1,2;";

               /* select count(*),date_trunc( 'month', time_stamp ) from rb group by date_trunc( 'month', time_stamp );*/
      $result = pg_query($query);  
      echo '<div class="userDashboard">
            <button type="button" class="collapsible">User Dashboard</button>
            <div class="dashboardContent"><p>';

      $query="SELECT round(COUNT(*) * 100.0 / (SELECT COUNT(*) 
              FROM activitydata INNER JOIN locationdata ON loc_id=location_id
              WHERE uploader='$_SESSION[userId]'
              AND (act_timestamp  BETWEEN date_trunc('month', CURRENT_DATE) - INTERVAL '12 month' AND date_trunc('month', CURRENT_DATE) - INTERVAL '1 month') AND (type='ON_FOOT' OR type='RUNNING' OR type='WALKING' OR type='ON_BICYCLE' or type='IN_VEHICLE' OR type='EXITING_VEHICLE'  ) ), 2) 
              AS score
              FROM activitydata INNER JOIN locationdata ON loc_id=location_id
              WHERE uploader='$_SESSION[userId]'
              AND (act_timestamp  BETWEEN date_trunc('month', CURRENT_DATE) - INTERVAL '12 month' AND date_trunc('month', CURRENT_DATE) - INTERVAL '1 month') 
              AND (type='ON_FOOT' OR type='RUNNING' OR type='WALKING' OR type='ON_BICYCLE');";


      $result = pg_query($query);

      if (pg_num_rows($result) > 0 ) {
        while($row = pg_fetch_assoc($result)) {
          if ( empty($row["score"])){
            echo "Score τρέχοντος μήνα χρήστη : Δεν υπάρχουν εγγραφές"; } 
          else {
             echo"Score τρέχοντος μήνα χρήστη " .$_SESSION['nameuser']." : ".$row["score"]. "%"; }
        }
      } else {echo "No insertions!"; }

      // update user's eco_score
      $insertq = "UPDATE xrhsths SET eco_score=(SELECT round(COUNT(*) * 100.0 / (SELECT COUNT(*) 
                      FROM activitydata INNER JOIN locationdata ON loc_id=location_id
                      WHERE uploader='$_SESSION[userId]'
                      AND (act_timestamp  BETWEEN date_trunc('month', CURRENT_DATE) - INTERVAL '12 month' AND date_trunc('month', CURRENT_DATE) - INTERVAL '1 month') AND (type='ON_FOOT' OR type='RUNNING' OR type='WALKING' OR type='ON_BICYCLE' or type='IN_VEHICLE' OR type='EXITING_VEHICLE'  )), 2) 
                      AS score
                      FROM activitydata INNER JOIN locationdata ON loc_id=location_id
                      WHERE uploader='$_SESSION[userId]'
                      AND (act_timestamp  BETWEEN date_trunc('month', CURRENT_DATE) - INTERVAL '12 month' AND date_trunc('month', CURRENT_DATE) - INTERVAL '1 month') 
                      AND (type='ON_FOOT' OR type='RUNNING' OR type='WALKING' OR type='ON_BICYCLE'))WHERE user_id='$_SESSION[userId]';";
      pg_query($db, $insertq) or die("Failed to execute query {$insertq}");

  //------- erwthma b : η περίοδος που καλύπτουν οι εγγραφές του χρήστη
        $query="SELECT MIN(to_char(loc_timestamp, 'DD-Mon-YYYY HH24:MI:SS')) AS first_record, MAX(to_char(loc_timestamp, 'DD-Mon-YYYY HH24:MI:SS')) AS last_record FROM locationdata WHERE uploader='$_SESSION[userId]';"; 
        $result = pg_query($query); 
        
        if (pg_num_rows($result) > 0) {
          while($row = pg_fetch_assoc($result)) {
            echo"</br></br>Περίοδος που καλύπτουν οι εγγραφές : </br>
                Από: $row[first_record]</br>\tΜέχρι: $row[last_record]";
          }
        } else {echo "No insertions!"; }

  //------- erwthma c : η ημερομηνία τελευταίου upload που έκανε ο χρήστης
        $query="SELECT MAX(to_char(upload_date, 'DD-Mon-YYYY HH24:MI:SS')) as last_upload FROM uploadslog WHERE uploader='$_SESSION[userId]'"; 
        $result = pg_query($query); 
        
        if (pg_num_rows($result) > 0) {
          while($row = pg_fetch_assoc($result)) {
            echo"</br></br>Hμερομηνία τελευταίου upload  : $row[last_upload]";
          }
        } else {echo "No insertions!"; }
       

         echo "</br></br>Last 12 months score :
              <table>
              <tr>
              <th>Month</th>
              <th>Score</th>
              </tr>
              <tr>";
        for ($x = 11; $x >= 0; $x--) {
          $y=$x+1; 
          $query="SELECT to_char(act_timestamp, 'YYYY-MM') AS month, round(COUNT(*) * 100.0 / (SELECT COUNT(*) 
                      FROM activitydata INNER JOIN locationdata ON loc_id=location_id
                      WHERE uploader='$_SESSION[userId]'
                      AND (act_timestamp  BETWEEN date_trunc('month', CURRENT_DATE) - '$y'*INTERVAL '1 month' AND date_trunc('month', CURRENT_DATE) - '$x'*INTERVAL '1 month') AND (type='ON_FOOT' OR type='RUNNING' OR type='WALKING' OR type='ON_BICYCLE' OR type='IN_VEHICLE' OR type='EXITING_VEHICLE'  )), 2)
                      AS score
                      FROM activitydata INNER JOIN locationdata ON loc_id=location_id
                      WHERE uploader='$_SESSION[userId]'
                      AND (act_timestamp  BETWEEN date_trunc('month', CURRENT_DATE) - '$y'*INTERVAL '1 month' AND date_trunc('month', CURRENT_DATE) - '$x'*INTERVAL '1 month') 
                      AND (type='ON_FOOT' OR type='RUNNING' OR type='WALKING' OR type='ON_BICYCLE' )
                      GROUP BY to_char(act_timestamp, 'YYYY-MM')
                      ORDER BY 1,2;";
          $result = pg_query($query);

          if (pg_num_rows($result) > 0) {
            // output data of each row
            while($row = pg_fetch_assoc($result)) {
            echo "<tr>";
                echo '<td>'.$row["month"].'</td>';
                echo '<td>'.$row["score"].'</td>';  
                  
            echo "</tr>";
            }
          }
        }
        echo "</table></p></div></div";

        
      }?>
    </div>
<!-------------- End of user Dashboard -------------->

<!-------------- Star of leaderboard-------------->
  <div class="main-content-div">
    <div class="userDashboard">
            <button type="button" class="collapsible">Eco Score Leaderboard</button>
            <div class="dashboardContent"><h2 style="text-align: center;">TOP 3 USERS</h2><p>
    <?php 
     echo "</br></br>
              <table>
              <tr>
              <th>Rank</th>
              <th>Name</th>
              <th>Eco_score</th>
              </tr>
              <tr>";
        $query="SELECT DENSE_RANK() OVER(ORDER BY eco_score DESC) AS rank, name, LEFT(surname, 1) as surname, eco_score 
                FROM xrhsths
                LIMIT 3;";
        $result = pg_query($query);
        if (pg_num_rows($result) > 0) {
          while($row = pg_fetch_assoc($result)) {
            echo "<tr>";
                echo '<td>'.$row["rank"].'</td>';
                echo '<td>'.$row["name"].".".$row["surname"].'</td>';
                echo '<td>'.$row["eco_score"].'</td>';
            echo "</tr>";
          }
        }
        echo "</br></br>
              <table>
              <caption>Your Rank!</caption>
              <tr>
              </tr>
              <tr>";

        $query="SELECT RANK() OVER(ORDER BY eco_score DESC) AS rank, name, LEFT(surname, 1) as surname, eco_score 
        FROM xrhsths WHERE eco_score>=(SELECT eco_score FROM xrhsths WHERE user_id='$_SESSION[userId]') 
        ORDER BY rank DESC LIMIT 1;";
        
        $result = pg_query($query);
        
        if (pg_num_rows($result) > 0) {
          while($row = pg_fetch_assoc($result)) {
            echo "<tr>";
                echo '<td>'.$row["rank"].'</td>';
                echo '<td>'.$row["name"].".".$row["surname"].'</td>';
                echo '<td>'.$row["eco_score"].'</td>';
            echo "</tr>";
          }
        }
        echo "</table></p></div>"; ?>
      </p></div>
  </div>
<!-------------- End of leaderboard-------------->

<!-------------- Start of map -------------->
  <div class="map">
    <div class="map-content container" >
      <?php if (isset($_SESSION['nameuser'])){echo '<div id="mapid"></div>'; } ?>
      
    </div>
  </div>

  <p id="erwthmaA"  style="width: 900px; height: 500px;"></p>
  <p id="qb"></p>
  <p id="erwthmaB"></p>
  <br>
  <p id="qc"></p>
  <p id="erwthmaC"></p>
<!-------------- end of map -------------->

<!-------------- end of main -------------->


<script language="JavaScript">
  function toggle(source) {
    checkboxes = document.getElementsByClassName('checkbox');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
  google.charts.load('current', {'packages':['corechart', 'table']});
</script>