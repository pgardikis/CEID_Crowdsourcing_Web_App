<?php

if (isset($_POST['loginButton'])) {

  require 'db.php';

  $username = $_POST['username'];
  $password = md5($_POST['psw']);


  if (empty($username) || empty($password)) {
    header("Location: ../index1.php?error=emptyfields");
    exit();  }
  else {
    $query = "SELECT * FROM xrhsths WHERE username = '$username' AND password = '$password';";
    $result = pg_query($query);
    if(pg_num_rows($result) != 1) {
// do error stuff
        header("Location: ./index.php?error=sqlerror"); exit(); } 
    else {
// user logged in
        $row = pg_fetch_assoc($result);
        session_start();
        $_SESSION['userId'] = $row['user_id'];
        $_SESSION['nameuser'] = $row['username'];

        header("Location: ./index.php");
        exit();
      }
     
    }
  }

else {
  header("Location: ./index.php");
  exit();
}