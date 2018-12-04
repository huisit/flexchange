<?php
  session_start();

  // Connect to the database
  require_once "backend/connect.php";
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if (isset($_POST['register']) && $_POST['register'] == 'START FLEXING') {

    // @TODO: Check to see if duplicate emails exist

    //first check to see if we've already got that email
    $prep = $dbh->prepare("SELECT * FROM user WHERE `email` = :email");
    $prep->execute(['email' => $_POST['email']]);
    $check = $prep->fetch(PDO::FETCH_ASSOC);

    //if we haven't already got the email, set a bool to
    if (!$check){
      $email_exists = FALSE;
    } else{
      $email_exists = TRUE;
    }

    //Check for any empty input fields
    if (!isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['email']) || !isset($_POST['pass']) || !isset($_POST['passconfirm']) || empty($_POST['email']) || empty($_POST['pass']) || empty($_POST['passconfirm'])) {
      $msg = "Please fill in all form fields.";
    }
    // passsword and password confirm should match
    else if ($_POST['pass'] !== $_POST['passconfirm']) {
      $msg = "Passwords must match.";
    }
    else if ($email_exists === TRUE){
      $msg = "An account with that email already exists.";
    }
    else {
      // Generate random salt
      $salt = hash('sha256', uniqid(mt_rand(), true));

      // Apply salt before hashing
      $salted = hash('sha256', $salt . $_POST['pass']);

      // Store the salt with the password, so we can apply it again and check the result
      $stmt = $dbh->prepare("INSERT INTO user (email, pass_hash, pass_salt, FirstName, LastName) VALUES (:email, :pass, :salt, :firstname, :lastname)");
      $stmt->execute(array(':email' => $_POST['email'], ':pass' => $salted, ':salt' => $salt, ':firstname'=>$_POST['firstname'], ':lastname'=>$_POST['lastname']));
      $msg = "Account created.";
    }
  }
?>
<!doctype html>
<html>
<head>
  <title>Sign Up</title>
  <?php include("common/head.html"); ?>
</head>
<body>
    <?php include("common/header.php"); ?>

    <h1>Sign up for FleXchange</h1>


    <div class="wrapper">
    <p>Please enter your details.</p>
    <?php if (isset($msg)) echo "<p>$msg</p>" ?>
    <form method="post" action="register.php">

      <div class="form-group">
        <label for="firstname" class="_label">First Name </label>
        <input type="text" name="firstname" class="form-control"/>
      </div>

      <div class="form-group">
        <label for="lastname" class="_label">Last Name </label>
        <input type="text" name="lastname" class="form-control"/>
      </div>

      <div class="form-group">
        <label for="email" class="_label">RPI Email </label>
        <input type="text" name="email" class="form-control"/>
      </div>

      <div class="form-group">
        <label for="pass" class="_label">Password </label>
        <input type="password" name="pass" class="form-control"/>
      </div>

      <div class="form-group">
        <label for="passconfirm" class="_label">Confirm Password</label>
        <input type="password" name="passconfirm" class="form-control"/>
      </div>

      <div class="form-group">
        <input type="submit" name="register" value="START FLEXING" class="btn"/>
      </div>

    </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>



</body>
</html>
