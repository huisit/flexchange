<?php
  session_start();
  $id = NULL;
  //check if user is logged in, if not redirect to login
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    $id = $_SESSION["id"];
  } else {
    header("Location: login.php");
    exit;
  }
  //ensure an id was found
  if (is_null($id)) {
    die("User ID could not be found");
  }
?>
