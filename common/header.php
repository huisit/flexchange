<?php
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

<header>
  <div id="head">
    <img id="logo" src="images/logo.png">
    <a href="profile.php"><img id="user" class="circleFrame" src="profilePictures/<?php echo $profilePicture ?>"></a>
  </div>
  <div id="nav">
    <a href="index.php">Home</a>
    <a href="search.php"><img src="images/search.png" width="12px"> Find Flex</a>
    <a href="logout.php" class="logout">Logout</a>
  </div>
</header>
