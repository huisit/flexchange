<?php
session_start();

// Connect to the database
require_once "backend/connect.php";

//If logged in, redirect to landing
if (isset($_SESSION['email'])) {
  header("Location: index.php");
}

// Check login
if (isset($_POST['login']) && $_POST['login'] == 'Login') {

  $salt_stmt = $dbh->prepare('SELECT pass_salt FROM user WHERE email=:email');
  $salt_stmt->execute(array(':email' => $_POST['email']));
  $res = $salt_stmt->fetch();
  $salt = ($res) ? $res['pass_salt'] : '';
  $salted = hash('sha256', $salt . $_POST['pass']);

  $login_stmt = $dbh->prepare('SELECT email, user_id, FirstName, LastName FROM user WHERE email=:email AND pass_hash=:pass');
  $login_stmt->execute(array(':email' => $_POST['email'], ':pass' => $salted));


  if ($user = $login_stmt->fetch()) {
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['FirstName'] = $user['FirstName'];
    $_SESSION['LastName'] = $user['LastName'];
    header("Location: index.php");
  }
  else {
    $err = 'Incorrect email or password.';
  }
}


?>
<!doctype html>
<html>
<head>
  <title>Login</title>
  <link rel="shortcut icon" href="">
  <?php
    include("common/head.html");
  ?>
  <link rel="stylesheet" type="text/css" href="style/login.css">
</head>
<body>
  <?php include("common/header.php"); ?>
  <div class="wrapper">
  <h1>Login to FleXchange</h1>
    
  <?php if (isset($err)) echo "<p>$err</p>" ?>
  <form method="post" action="login.php">
    
    <div class="formgroup">
      <label for="email" class="_label">RPI Email </label>
      <input type="text" name="email" class="form-control" />
    </div>
    
    <div class="formgroup">
      <label for="pass" class="_label">Password</label>
      <input type="password" name="pass" class="form-control"/>
    </div>
    
     <input name="login" type="submit" value="LOGIN" class="btn"/>
  </form>
  <p>Don't have an account? <a href="register.php">Sign up now</a></p>
  
  
  
</body>
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

</html>
