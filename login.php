<?php
session_start();

// Connect to the database
require_once "backend/connect.php";

// Check login
if (isset($_POST['login']) && $_POST['login'] == 'Login') {
  
  $salt_stmt = $dbh->prepare('SELECT pass_salt FROM user WHERE email=:email');
  $salt_stmt->execute(array(':email' => $_POST['email']));
  $res = $salt_stmt->fetch();
  $salt = ($res) ? $res['pass_salt'] : '';
  $salted = hash('sha256', $salt . $_POST['pass']);


  
  $login_stmt = $dbh->prepare('SELECT email, user_id FROM user WHERE email=:email AND pass_hash=:pass');
  $login_stmt->execute(array(':email' => $_POST['email'], ':pass' => $salted));
  
  
  if ($user = $login_stmt->fetch()) {
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_id'] = $user['user_id'];
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
<<<<<<< HEAD
  <link rel="stylesheet" href="style/style.css">
=======
  <link rel="stylesheet" type="text/css" href="register_style.css">
>>>>>>> 795993dcbec04f28392c0facfbe72ffd749d6b63
</head>
<body>
        <?php
          include("common/header.php");
        ?>
  <?php if (isset($_SESSION['email'])): ?>
  <?php header("Location: index.php"); ?>

  <?php else: ?>
  <h1>Login</h1>
  <?php if (isset($err)) echo "<p>$err</p>" ?>
  <form method="post" action="login.php">
    <label for="email">RPI Email: </label><input type="text" name="email" />
    <label for="pass">Password: </label><input type="password" name="pass" />
    <input name="login" type="submit" value="Login" />
  </form>
  <p>Don't have an account? <a href="register.php">Sign up now</a></p>
  <?php endif; ?>
</body>
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="lab9.js"></script>

</html>
