<?php  
include '../db.php';
session_start() ;

header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=export_data.csv');  
$output = fopen("php://output", "w");  
fputcsv($output, array(
		'type',
		'confidence',
		'accuracy',
		'longitude',
		'latitude',
		'timestamp',
		'userID' 
));  
$m1 = $_POST['m1'];
$m2 = $_POST['m2'];
$y1 = $_POST['y1'];
$y2 = $_POST['y2'];

$w = $_POST['w'];
$b =$_POST['b'];
$s = $_POST['s'];
$t = $_POST['t'];
$iv = $_POST['iv'];
$ev = $_POST['ev'];
$u = $_POST['u'];
$values = array($w, $b, $s, $t, $iv, $ev, $u);
$valuelist = implode(", ", $values);
$t1 = $_POST['t1'];
$t2 = $_POST['t2'];
$d1 = $_POST['d1'];
$d2 = $_POST['d2'];
$q = "SELECT  type, confidence, accuracy, longitude, latitude, loc_timestamp, 
		locationdata.uploader FROM locationdata INNER JOIN activitydata ON  locationdata.location_id = activitydata.loc_id  
		WHERE EXTRACT(MONTH FROM loc_timestamp) BETWEEN $m1 AND $m2
		AND EXTRACT(YEAR FROM loc_timestamp) BETWEEN $y1 AND $y2  
		AND EXTRACT(DAY FROM loc_timestamp) BETWEEN $d1 AND $d2
		AND EXTRACT(HOUR FROM loc_timestamp) BETWEEN $t1 AND $t2
		AND type IN ($valuelist)
		ORDER BY locationdata.location_id DESC;";  

	$query = pg_query($db, $q);  

	while($r = pg_fetch_assoc($query)) {  
		fputcsv($output, $r);  
	}  
	fclose($output); 
?>  
