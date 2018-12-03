<?php
  //Make sure the user is logged in
  require_once "backend/ensureSession.php";
  require "backend/connect.php";

  if (isset($_POST['details'])) {
    $subject = $_SESSION['FirstName'] . " wants to FleXchange with you!";
    $message = "
      <html>
        <head>
          <title>" . $_SESSION['FirstName'] . " wants to FleXchange with you!</title>
        </head>
        <body>
          <h1>" . $_SESSION['FirstName'] . " wants to FleXchange with you!</h1>
          <p>Here are their details on how to find them:</p>
          <p>" . $_POST['details'] . "</p>
          <button>Confirm meeting</button>
          <button>Decline exchange</button>
        </body>
      </html>
    ";
    $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso8859-1\r\n";
    $headers .= "From: FleXchange No-Reply <flexchange.noreply@gmail.com>\r\n";
    mail($_POST['email'], $subject, $message, $headers);
    echo $_POST['email'];
    echo $subject;
    echo $message;
    echo $headers;
    // echo "<script type='text/javascript'>alert('You will recieve an email if they confirm to meet with you')</script>";
    // header("Location: search.php");
  }
?>
<!doctype html>
<html>
<head>
  <title>Login</title>
  <link rel="shortcut icon" href="">
  <?php include("common/head.html"); ?>
</head>
<body>
  <?php include("common/header.php"); ?>
  <h1>Contact</h1>
  <form method="post" action="email.php">
    <input type='hidden' name='email' value=" <?php echo $_POST['email'] ?> ">
    <input type='hidden' name='name' value=" <?php echo $_POST['name'] ?> ">
    <label for="details">Provide details for <?php echo $_POST['name'] ?> to find you: </label><input type="text" name="details" />
    <input name="mail" type="submit" value="Send" />
  </form>
  <p>Note: your first name and profile picture will be sent to them</p>
  <br />
</body>
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="lab9.js"></script>

</html>
