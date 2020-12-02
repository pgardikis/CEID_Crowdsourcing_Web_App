<?php
session_start();
require('./header.php');
include 'getDistance.php';
ini_set('memory_limit','2048M'); // increase php memory limit for file upload

set_time_limit(0); 
$pword = "password=1234";
$username = $_SESSION['nameuser'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

//print_r($vertices_x);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if (file_exists($target_file)) {$uploadOk = 0;}

if ($uploadOk == 1) {

    $json_file = $target_file;
    $json_cont = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
    $json_dec = json_decode($json_cont, true);
    $file_parts = pathinfo($json_file);

    if($json_file === FALSE) {
        die('Could not open file!');
    }
    else {
        $db_connection = pg_connect("host=localhost port=5432 dbname=web20 user=postgres $pword") or die('Could not connect: ' . pg_last_error());
    }

    /* {locations :[{
    *     timestampMs,
    *     latitudeE7,
    *     longitudeE7,
    *     accuracy,
    *     activity : [{
    *       timestampMs,
    *       activity :[{
    *         type,confidence
    *       }]
    *     }]
    *   }]
    */

    // σκεφτειτε το αρχειο μετα το decode σαν array of arrays δλδ 
    // locations[timestampMs,latitudeE7,...,activity[timestampMs,activity[type,confidence]]]

    foreach($json_dec['locations'] as $locations) { // locations[για καθε στοιχειο του array]
        //highlight_string(print_r ($locations['accuracy'], true));

        if(array_key_exists('latitudeE7', $locations)) {
            $latitude = (float) $locations['latitudeE7']/1e7;
        }

        if(array_key_exists('longitudeE7', $locations)) {
            $longitude = (float) $locations['longitudeE7']/1e7;
        }

    $x = $_POST['x'];
    //echo $x;
    $vertices_x = explode(",", $x);
    $y = $_POST['y'];
    //echo $y;
    $vertices_y = explode(",", $y);
    $points_polygon = count($vertices_x) - 1;
    if (!is_in_polygon($points_polygon, $vertices_x, $vertices_y, $latitude, $longitude)){


        $distance = getDistance($latitude, $longitude);
        if($distance < 10) {
            if(array_key_exists('accuracy', $locations)) {
                $acc = (int) $locations['accuracy'];
                if($acc<5000){
                    $accuracy = $acc;
                    if(array_key_exists('activity', $locations)) { 
                        foreach($locations['activity'] as $l_activ) { // για καθε στοιχειο του subarray locations[...,activity[ειμαστε εδω μεσα]]
                            if(array_key_exists('activity', $locations)) {
                                $tempconf = 0; 
                                foreach($l_activ['activity'] as $l_a_activ) { // για καθε στοιχειο του subarray locations[...,activity[..,activity[ειμαστε εδω μεσα]]]
                                    if(array_key_exists('confidence', $l_a_activ)) {
                                        $conf = (int) $l_a_activ['confidence'];
                                        
                                        if($conf>$tempconf){
                                            $confidence = $conf;
                                            $tempconf = $conf;
                                            if(array_key_exists('type', $l_a_activ)) {
                                                $type = $l_a_activ['type']; 
                                            }
                                            if(array_key_exists('timestampMs', $l_activ)){
                                                $astamp = $l_activ['timestampMs'];
                                                $act_timestamp = date('Y-m-d H:i:s',$astamp/1000);
                                            }
                                            if(array_key_exists('timestampMs', $locations)) { // αν υπαρχει το locations[timestampMs] αποθηκευσε το στη μεταβλητη $timestamp
                                                $lstamp = $locations['timestampMs'];
                                                $loc_timestamp = date('Y-m-d H:i:s',$lstamp/1000);
                                            }
                                    
                                            if(array_key_exists('latitudeE7', $locations)) {// αντιστοιχα με πανω
                                                $latitude = (float) $locations['latitudeE7']/1e7;
                                            }
                                    
                                            if(array_key_exists('longitudeE7', $locations)) {
                                                $longitude = (float) $locations['longitudeE7']/1e7;
                                            }
                                        }
                                    }
                                }
                            }
                            $query = "WITH locrows as(
                                INSERT INTO locationdata (loc_timestamp, latitude, longitude, accuracy, uploader) 
                                VALUES ('$loc_timestamp', '$latitude', '$longitude', '$accuracy', (SELECT user_id FROM xrhsths WHERE username='$username'))
                                RETURNING location_id)
                                INSERT INTO activitydata (type, confidence, act_timestamp, loc_id)
                                SELECT '$type', '$confidence', '$act_timestamp', location_id
                                FROM locrows
                                WHERE $confidence>=65;";
                            pg_query($db_connection,$query) or die("Could not execute this insert statement: ".pg_last_error());
                            
                        }
                    }
                }
            }
        }
    }

    }
}
$query = "INSERT INTO uploadslog (uploader, upload_date) 
          VALUES ( (SELECT user_id FROM xrhsths WHERE username='$username'), current_timestamp)";
pg_query($db_connection,$query) or die("Could not execute this insert statement: ".pg_last_error());
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patras Hottest Spots</title>
    <link rel="stylesheet" href="./css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/main.js"></script>
</head>
  <body>
    <div class="div1">
      <?php // Check if file exists

        if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;}
        if ($uploadOk == 0) {echo nl2br("\nPlease select a file."); }
        else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
              if(strcmp($file_parts['extension'],"json") == 0){
                echo nl2br("\nSuccessfully loaded to database!");
                if (!unlink($target_file)) {  
                    echo ("$target_file cannot be deleted due to an error");  
                }  
            }
        } 
            else {
              echo "Sorry, there was an error uploading your file.";
            }
        }
              
?>
      <a href="./uploadpage.php">
        <button class="button" id="back" style="vertical-align: middle"><span>Back to upload page </span></button>
      </a>
    </div>
  </body>
</html>

