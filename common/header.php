<?php
  //Find the user's profile picture, if they're logged in
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    require_once "backend/connect.php";
    $stmt = $dbh->prepare("SELECT `img_name` FROM user WHERE user_id = :id");
    $id = $_SESSION["id"];
    $stmt->execute($id);
    $profilePicture = $stmt->fetch();
    if (is_null($profilePicture)) {
      $profilePicture = "default.png";
    }
  } else {
    $profilePicture = "default.png";
  }
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>   
  </head>
  <header>
    <!-- Logo and profile -->
    <div id="head">
      <img id="logo" src="images/logo.png">
      <a href="profile.php"><img id="user" class="circleFrame" src="profilePictures/<?php echo $profilePicture ?>"></a>
    </div>
    <!-- Webpages -->
    <div id="nav">
      <a href="index.php">Home</a>
      <a href="search.php"><img src="images/search.png" width="12px"> Find Flex</a>
      <a href="logout.php" class="logout">Logout</a>
    </div>
  </header>
</html>
