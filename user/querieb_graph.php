<?php 
include '../db.php';
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
$username = $_SESSION['nameuser'];
$values = array($w, $b, $s, $t, $iv, $ev, $u);
$valuelist = implode(", ", $values);

$query="SELECT DISTINCT ON(type) type AS activity, to_char(act_timestamp, 'HH24') AS tophour, count(*) AS num_of_records
FROM activitydata
INNER JOIN locationdata ON loc_id=location_id
INNER JOIN xrhsths ON uploader=user_id 
WHERE username='$username' AND to_char(act_timestamp, 'MM') BETWEEN '$m1' AND '$m2' AND to_char(act_timestamp, 'YYYY') BETWEEN '$y1' AND '$y2'
GROUP BY activity ,tophour
ORDER BY activity, num_of_records DESC;";

$result = pg_query($query) or die("Failed to execute query {$query}");
echo json_encode(array_values(pg_fetch_all($result)));

?>