
<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
     $(document).ready(function(){
        $("#adminLoginButton").click(function(){
          $("#adminloginForm").toggle();
          $("#signupForm").hide();
          $("#userloginForm").hide();
        });
      });
      $(document).ready(function(){
        $("#userLoginButton").click(function(){
          $("#userloginForm").toggle();
          $("#adminloginForm").hide();
          $("#signupForm").hide();
        });
      });
      $(document).ready(function(){
        $("#signupButton").click(function(){
          $("#signupForm").toggle();
          $("#adminloginForm").hide();
          $("#userloginForm").hide();
        });
      });
  </script>
</head>

<header>
  <div class="header-inner container clearfix">
			<div class="branding" id="dimitris">
				<a href="./index.php">
					<img src="/web20/images/logo.png" alt="logo" title="logo">
				</a>
			</div>

			<div class="info-menu">
				<ul class="menu">
					<li><a href="#">About us</a></li>
					<li><a href="#">Contact</a></li>
          <?php if (isset($_SESSION['nameuser']) and !isset($_SESSION['adminId'])) { 
            echo '<li><a href="/web20/uploadpage.php">Upload File</a></li>';}
          ?>
				</ul>
			</div>

			<div class="main-menu">
				<ul class="menu">

 <!---------------- Log in ----------------->
<?php
  if (isset($_SESSION['nameuser'])) {
    echo '<li ><a id="welcome">You are logged in as  ' . $_SESSION['nameuser'] . '</a></li>';
    echo '<li><form action="/web20/logout.php" method="post">
      <button id="logoutButton" type="submit" name="logout-submit">Logout</button>
    </form></li>';
  }
  else { if (isset($_GET['error'])) {
    if ($_GET['error'] == "nouser") {
        echo '<p class="signuperroer">Wrong user!</p>';
      }
      else if ($_GET['error'] == "wrongpassword") {
        $message = "Wrong password!";
        echo "<script type='text/javascript'>alert('$message');</script>";
      }
    
    }
    echo '<li><a class=open-button id="adminLoginButton" href="#">Login as Admin</a></li>
					<li><a class=open-button id="userLoginButton" href="#">Login as User</a></li>
          <li><a class=open-button id="signupButton" href="#">Sign Up</a></li>';
  }
?>
				</ul>

        <!---------------------adminloginForm -------------------->
        <div class="form-popup" id="adminloginForm">
          <form action="./admin/adminLogin.php" class="form-container" method="POST">
            <label for="adminusername"><b>Admin Username</b></label>
            <input type="text" placeholder="Enter Username" name="adminusername" required>
            <label for="adminpsw"><b>Admin Password</b></label>
            <input type="password" placeholder="Enter Password" name="adminpsw" required>
            <button type="submit" class="btn" name="adminloginButton">Login</button>
            <button type="button" class="btn cancel" onclick="closeLoginForm()" href="#">Close</button>
          </form>
        </div>

        <!------------------------ userloginForm--------------------->
        <div class="form-popup" id="userloginForm">
          <form action="./login.php" class="form-container" method="POST">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>
            <button type="submit" class="btn" name="loginButton">Login</button>
            <button type="button" class="btn cancel" onclick="closeLoginForm()" href="#">Close</button>
          </form>
			  </div>

<!---------------- Sign Up ----------------->
<?php
  if (isset($_GET['error'])) {
    if ($_GET['error'] == "emptyfields") {
      echo '<p class="signuperroer">Fill all fields!</p>';
    }
    else if ($_GET['error'] == "invalidmailuid") {
      echo '<p class="signuperroer">invalid username and email</p>';
    }
    else if ($_GET['error'] == "invaliduid") {
      echo '<p class="signuperroer">invalid username</p>';
    }
    else if ($_GET['error'] == "invalidPassword") {
      echo '<p class="signuperroer">Password must be a minimum of 8 characters and contain at least one capital letter, a number and a special character such as an underscore or exclamation point.</p>';
    }
    else if ($_GET['error'] == "passwordcheck") {
      echo '<p class="signuperroer">your password do not match!</p>';
    }
    else if ($_GET['error'] == "usertaken") {
      echo '<p class="signuperroer">username is already taken!</p>';
    }
  }
  else if (isset($_GET['signup']) && $_GET['signup'] == "success") {
    echo '<p class="signupsuccess">success!</p>';
  }
 ?>
         <!-------------------- signupform ==========================-->
        <div class="form-popup" id="signupForm" style="">
          <form action="./signup.php" class="form-container" method="post" style="">
            <label for="username"><b>Username</b></label>
            <input type="text" name="username" placeholder="Username">
            <label for="name"><b>Name</b></label>
            <input type="text" name="su_name" placeholder="Name">
            <label for="surname"><b>Surname</b></label>
            <input type="text" name="su_surname" placeholder="Surname">
            <label for="pwd"><b>Password</b></label>
            <input type="password" name="pwd" placeholder="Password">
            <input type="password" name="pwd-repeat" placeholder="Repeat Password">
            <label for="email"><b>Email</b></label>
            <input type="text" name="email" placeholder="E-mail">
            <button type="submit" class="btn" name="signup-submit">Signup</button>
            <button type="button" class="btn cancel" name="signup-submit" onclick="closeSignupForm()">Close</button>
          </form>
      </div>
		</div>
  </div>
</header>
</html>