<?php 
include './db.php';
session_start() ;


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

if (isset($_SESSION['nameuser']) and !isset($_SESSION['adminId'])) { 

    $query="SELECT latitude as lat, longitude as lng, 1 as

       count
		FROM locationdata INNER JOIN activitydata ON loc_id=location_id
		WHERE EXTRACT(MONTH FROM loc_timestamp) BETWEEN $m1 AND $m2
		AND EXTRACT(YEAR FROM loc_timestamp) BETWEEN $y1 AND $y2  
		AND type IN ($valuelist)  
		AND uploader='$_SESSION[userId]' "; }
else {
		$t1 = $_POST['t1'];
		$t2 = $_POST['t2'];
		$d1 = $_POST['d1'];
		$d2 = $_POST['d2'];
		$query="SELECT latitude as lat, longitude as lng, 1 as
        count
		FROM locationdata INNER JOIN activitydata ON loc_id=location_id
		WHERE EXTRACT(MONTH FROM loc_timestamp) BETWEEN $m1 AND $m2
		AND EXTRACT(YEAR FROM loc_timestamp) BETWEEN $y1 AND $y2  
		AND EXTRACT(DAY FROM loc_timestamp) BETWEEN $d1 AND $d2
		AND EXTRACT(HOUR FROM loc_timestamp) BETWEEN $t1 AND $t2
		AND type IN ($valuelist) ";
	 }

$result = pg_query($query); 
$final = json_encode(array_values(pg_fetch_all($result)));
echo json_encode(array_values(pg_fetch_all($result)));
?>