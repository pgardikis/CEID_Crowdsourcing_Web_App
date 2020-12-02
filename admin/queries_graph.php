
<?php
include '../db.php';

$erwthma = $_GET['querie'];

switch ($erwthma) {
  case "querieA":
    $query = "SELECT count(activity_id) AS number_of_records, type AS joker
    FROM locationdata
    INNER JOIN activitydata ON loc_id=location_id
    GROUP BY type;";
    $qresult = pg_query($query);
    echo json_encode(array_values(pg_fetch_all($qresult)));
   break;


  case "querieB":
    $query = "SELECT count(activity_id) AS number_of_records, uploader AS joker
    FROM locationdata
    INNER JOIN activitydata ON loc_id=location_id
    GROUP BY uploader;";
    $qresult = pg_query($query);
    echo json_encode(array_values(pg_fetch_all($qresult)));
  break;



  case "querieC":
    $query = "SELECT count(activity_id) AS number_of_records, to_char(act_timestamp, 'Mon') AS joker
    FROM activitydata 
    GROUP BY joker;";
    $qresult = pg_query($query);
    echo json_encode(array_values(pg_fetch_all($qresult)));
  break;


  case "querieD":
    $query = "SELECT count(activity_id) AS number_of_records, to_char(act_timestamp, 'Day') AS joker
    FROM activitydata 
    GROUP BY joker;";
    $qresult = pg_query($query);
    echo json_encode(array_values(pg_fetch_all($qresult)));
  break;


  case "querieE":
    $query = "SELECT count(activity_id) AS number_of_records, to_char(act_timestamp, 'HH24') AS joker
    FROM activitydata 
    GROUP BY joker
    ORDER BY joker;";
    $qresult = pg_query($query);
    echo json_encode(array_values(pg_fetch_all($qresult)));
  break;
  


  case "querieF":
    $query = "SELECT count(activity_id) AS number_of_records, to_char(act_timestamp, 'YYYY') AS joker
    FROM activitydata
    GROUP BY joker
    ORDER BY joker;";
    $qresult = pg_query($query);
    echo json_encode(array_values(pg_fetch_all($qresult)));
  break;


  case "querieG":
    $query="SELECT * 
                FROM locationdata;";
      $result = pg_query($query); 
      if (pg_num_rows($result) > 0) {
      while($row=pg_fetch_assoc($result)) 
      {
        $prepared = array("lat" => $row['latitude'], "lng" => $row['longitude'], "count" => 1);
        $prepared = json_encode($prepared);
        echo json_encode($prepared);
        echo "string";
      } } 
}

?>