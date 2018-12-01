<?php
  //Initialize session
  session_start();

  //Unset all session variables
  $_SESSION = array();

  //Destroy session
  session_destroy();

  //Redirect to login page
  header("Location: login.php");
  exit;
?>
