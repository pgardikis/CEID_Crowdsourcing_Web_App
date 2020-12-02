<?php
if (isset($_POST['adminloginButton'])) {

  require '../db.php';

  $username = $_POST['adminusername'];
  $password = $_POST['adminpsw'];


  if (empty($username) || empty($password)) {
    header("Location: ../index1.php?error=emptyfields");
    exit();  }
  else {
    $query = "SELECT * FROM administrator WHERE username = '$username' AND password = '$password';";
    $result = pg_query($query);
    if(pg_num_rows($result) != 1) {
// do error stuff
        header("Location: ../index.php?error=sqlerror"); exit(); } 
    else {
// user logged in
        $row = pg_fetch_assoc($result);
        session_start();
        $_SESSION['adminId'] = $row['admin_id'];
        $_SESSION['nameuser'] = $row['username'];

        header("Location: ./newindex.php");
        exit();
      }
     
    }
  }

else {
  header("Location: ./index.php");
  exit();
}

?>