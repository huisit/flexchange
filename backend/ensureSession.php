<?php
  //Check if user is logged in, if not redirect to login
  session_start();
  if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
  }
?>
