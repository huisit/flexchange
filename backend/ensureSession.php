<?php
  session_start();
  //check if user is logged in, if not redirect to login
  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("Location: login.php");
  }
?>
