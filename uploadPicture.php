<?php
  require_once "backend/ensureSession.php"; //Ensure the user is logged in
  require_once "backend/connect.php"; //Connect to the database

  //check if user is logged in, if not redirect to login
  if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
  }

  //get image data
  $uploadSize = $_FILES["profilePicture"]["size"];
  $fileType = strtolower(pathinfo(basename($_FILES["profilePicture"]["name"]), PATHINFO_EXTENSION));

  //define upload vars
  $fileName = $_SESSION["user_id"] . "." . $fileType;
  $target = "profilePictures/" . $fileName;
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
    if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target)) {
      echo "The picture has been uploaded";
      $stmt = $dbh->prepare("UPDATE user SET img_name = :img_name WHERE user_id = :id");
      $stmt->execute(['img_name' => $fileName, 'id' => $_SESSION['user_id']]);
      header("Location: profile.php");
    } else {
      echo 'Error: ', PHP_EOL;
      print_r(error_get_last());
    }
  } else {
    echo "Your file was not uploaded<br>";
  }
?>
