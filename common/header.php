<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>
  <header>
    <!-- Logo and profile -->
    <div id="head">
      <img id="logo" src="images/logo.png">
      <?php
        //Find the user's profile picture, if they're logged in
        if (isset($_SESSION["user_id"])) {
          require_once "backend/connect.php";
          $pic_stmt = $dbh->prepare("SELECT `img_name` FROM user WHERE user_id = :id");
          $pic_stmt->execute(['id' => $_SESSION["user_id"]]);
          $profilePicture = $pic_stmt->fetch()[0];
          if (is_null($profilePicture) || $profilePicture == "") {
            $profilePicture = "default.png";
          }
          echo "<a href='profile.php'><img id='user' class='circleFrame' src='profilePictures/" . $profilePicture . "'></a>";
        }
      ?>
    </div>
    <!-- Webpages -->
    <div id="nav">
      <a href="index.php">Home</a>
      <a href="search.php"><img src="images/search.png" width="12px"> Find Flex</a>
      <?php
        if (isset($_SESSION["user_id"])) {
          echo "<a href='logout.php'>Logout</a>";
        } else {
          echo "<a href='login.php'>Login</a>";
        }
      ?>
    </div>
  </header>
</html>
