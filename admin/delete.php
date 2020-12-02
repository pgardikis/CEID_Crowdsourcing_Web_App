
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

<h1 style="margin-left:10%"></h1>
<div style="margin-left:25%;padding:1px 16px;height:1000px;">
<!-- <button class="btn"><i class="fa fa-home"></i></button> -->
  <form action="./newindex.php">
    <button type="sumbit" class="btn"><i class="fa fa-home"></i></button>
  </form>

<div>

<?php
// Prevent users from navigating to admin page without beeing logged in as Admin
session_start();
if(!isset($_SESSION['adminId']))
{
    header('Location: ../index.php?error=malicious');
    exit();
} 

$pword = "password=1234";
$db = pg_connect("host=localhost port=5432 user=postgres $pword") or die("Could not connect");
$db = pg_connect("host=localhost port=5432 dbname=web20 user=postgres $pword");

$query = "TRUNCATE TABLE activitydata, locationdata;";
$result = pg_query($query);
echo "Deleted ALL location data!"
?>