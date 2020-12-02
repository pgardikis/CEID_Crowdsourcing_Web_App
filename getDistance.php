<?php
// συνάρτηση για την εύρεση των συντεταγμένων που βρίσκονται μέσα στην ακτίνα των 10 km από το δοθέν σημείο, με συντεταγμένες (latitude=38.230462 , longitude=21.753150)
function getDistance($jlat, $jlong, $latP = 38.230462, $longP = 21.753150) {
  $earth_radius = 6371;  
  
  $deltaLat = deg2rad($latP - $jlat);  
  $deltaLong = deg2rad($longP - $jlong);  

  $a = sin($deltaLat/2) * sin($deltaLat/2) + cos(deg2rad($jlat)) * cos(deg2rad($latP)) * sin($deltaLong/2) * sin($deltaLong/2);  
  $c = 2 * asin(sqrt($a));  
  $d = $earth_radius * $c;  
  
  return $d;  
}

/*$vertices_x = array(38.24511874459838, 38.24742023768325, 38.24742023768325, 38.24511874459838);    // x-coordinates of the vertices of the polygon
$vertices_y = array(21.73373771059151,21.73373771059151,21.736977525149737,21.736977525149737); // y-coordinates of the vertices of the polygon*/
/*$points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
$longitude_x = $_GET["longitude"];  // x-coordinate of the point to test
$latitude_y = $_GET["latitude"]; */   // y-coordinate of the point to test



function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
{
  $i = $j = $c = 0;
  for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) {
    if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
     ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) )
       $c = !$c; 
  }
  return $c;
}


// ΤΑ ΑΦΗΝΩ ΣΕ ΣΧΟΛΙΑ ΜΗΠΩΣ ΘΕΛΗΣΟΥΜΕ ΝΑ ΤΣΕΚΑΡΟΥΜΕ ΤΠΤ ΚΑΙ ΤΑ ΔΙΑΓΡΑΦΟΥΜΕ ΜΕΤΑ 
// $distance = getDistance(38.2451943, 21.7663618);
// if ($distance < 10) {
//   echo $distance;
//   echo "Within 10 kilometer radius";
// } else {
//   echo $distance;
//   echo "Outside 10 kilometer radius";
// }
?>