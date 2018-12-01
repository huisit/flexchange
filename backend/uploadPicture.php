<?php
  session_start();
  //check if user is logged in, if not redirect to login
  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) {
    header("location: login.php");
    exit;
  }

  //get image data
  $uploadSize = $_FILES["uploadFile"]["size"];
  $fileType = strtolower(pathinfo(basename($_FILES["uploadFile"]["name"]), PATHINFO_EXTENSION));

  //define upload vars
  $target = "/profilePictures/" . $_SESSION["id"] . "." . $fileType;
  $canUpload = true;

  // //check server disk space
  // if  (diskfreespace("/") < (1024 * (1024 * 25))) {
  //   echo "CRITICAL ERROR: Our server disk space is lower than 25MB: '" . diskfreespace("/") . "'<br>";
  //   $canUpload = false;
  // }

  //allow only pictures
  if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
    echo "Only JPG, JPEG, PNG & GIF files are allowed - File is " . $fileType . "<br>";
    $canUpload = false;
  }

  //make it less than 5MB
  if ($uploadSize > (1024 * (1024 * 5))) {
    echo "The file must be less than 5MB - File size is " .
      round($uploadSize/1024/1024, 2, PHP_ROUND_HALF_UP) . "MB <br>"; //error rounds 2 deicmal points
    $canUpload = false;
  }

  //if everything works try to upload
  if ($canUpload) {
    if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target)) {
      echo "The picture has been uploaded";
    } else {
      echo 'Error: ', PHP_EOL;
      print_r(error_get_last());
    }
  } else {
    echo "Your file was not uploaded<br>";
  }
?>
