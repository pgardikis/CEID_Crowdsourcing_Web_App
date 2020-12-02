<?php
session_start();
if (isset($_POST['signup-submit'])) {

  require  'db.php';

  $username = $_POST['username'];
  $name = $_POST['su_name'];
  $surname = $_POST['su_surname'];
  $password = $_POST['pwd'];
  $email = $_POST['email'];
  $passwordRepeat = $_POST['pwd-repeat'];
  

  if (empty($username) || empty($name) || empty($surname) || empty($password) || empty($passwordRepeat) || empty($email)) {
    header("Location: ./index.php?error=emptyfields&uid=".$username);
    exit(); // ama yparxei lathos stamataei edw o kwdikas
  }
  else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: ./index.php?error=invaliduid&uid=".$username);
    exit();
  }
  else if (!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/", $password)) {
    header("Location: ./index.php?error=invalidPassword&uid=".$username);
    exit();
  }
  else if ($password !== $passwordRepeat) {
    header("Location: ./index.php?error=passwordcheck&uid=".$username);
    exit();
  }
  else {      
      $passwordHash = md5($password);
      $query = "INSERT INTO xrhsths (user_id, username, name, surname, password, email) 
                VALUES ( crypt('$username','$password'), '$username', '$name', '$surname', '$passwordHash', '$email')";
      $result = pg_query($query);                             
  }
header("Location: ./index.php?signup=success");
}
else {
  header("Location: ./index.php");
  exit();
}
// Closing connection
pg_close($db);
