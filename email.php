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
          <style>
            .btn {
              width: 200px;
              border: none;
              padding: 1em;
              font-weight: bold;
              color: white;
              border-radius: 3px;
              background-color: #D83D3D;
              opacity: 0.8;
              margin-bottom: 1em;
            }

            .btn:hover {
              opacity: 1;
              cursor: pointer;
            }
          </style>
          <h1>" . $_SESSION['FirstName'] . " wants to FleXchange with you!</h1>
          <p>Here are their details on how to find them:</p>
          <p>" . $_POST['details'] . "</p>
          <button class='btn'>Confirm meeting</button></br>
          <button class='btn'>Decline exchange</button>
        </body>
      </html>
    ";
    $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso8859-1\r\n";
    $headers .= "From: FleXchange No-Reply <flexchange.noreply@flexchange.com>\r\n";
    mail($_POST['email'], $subject, $message, $headers);
    // header("Location: search.php");
    $msg = "Email sent! You will recieve an email when they confirm or decline.";
  }
?>
<!doctype html>
<html>
  <head>
    <title>Contact</title>
    <?php include("common/head.html"); ?>
  </head>
  <body>
    <?php include("common/header.php"); ?>
    <h1>Contact</h1>
    <main>
      <?php if (isset($msg)) echo "<strong class=msg>".$msg."</strong>" ?>
      <form method="post" action="email.php">
        <input type='hidden' name='email' value=" <?php echo $_POST['email'] ?> ">
        <input type='hidden' name='name' value=" <?php echo $_POST['name'] ?> ">
        <label for="details">Provide details for <?php echo $_POST['name'] ?> to find you: </label><input type="text" name="details" class="form-control" />
        <br>
        <input name="mail" type="submit" value="Send" class="btn" />
      </form>
      <p class="tiny">Note: your first name and profile picture will be sent to them</p>
    </main>
  </body>
</html>
