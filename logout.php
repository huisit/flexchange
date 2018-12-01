<?php
//initialize session
session_start();

//Unset all session variables
$_SESSION = array();

//destroy session
session_destroy();

//redirect to login page
header("location: login.php");
exit;


 ?>
