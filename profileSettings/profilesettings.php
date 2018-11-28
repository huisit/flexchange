<?php
  session_start();
  $id = NULL;
  //check if user is logged in, if not redirect to login
  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
    $id = $_SESSION["id"];
  } else {
    header("location: login.php");
    exit;
  }
  //ensure an id was found
  if (is_null($id)) {
    die("User ID could not be found");
  }
  //connect to the database
  require_once "connect.php";

  $stmt = $pdo->prepare("SELECT FirstName, LastName, email FROM users WHERE user_id = :id");
  $stmt->execute(['id' => $id]);
  $user = $stmt->fetch();
  $name = $user["FirstName"] . $user["LastName"];
  if (is_null($name)) {
    $name = "ERROR: Invalid Name";
  }
  $email = $user["email"];
?>

<html>
  <head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="profile_style.css"></link>
    <script src="jquery-3.3.1.min.js"></script>
    <script src="test.js"></script>
  </head>
  <body>
    <div class="vcard">
      <header class="mediaBox">
        <div class="profilePicture mediaPicture">
          <?php
            $pictureLocation = "/profilePictures/" . $id . ".png";
            if (!file_exists($pictureLocation)) {
              $pictureLocation = "/profilePictures/default.png";
            }
            echo "<img class='photo circleFrame' src='" . $pictureLocation . "' width='80'></img>";
          ?>
          <img class="editOverlay circleFrame" src="overlay.png" width="80" alt="Click to change profile picture"></img>
          <form action="uploadPicture.php" method="post">
            <input type="file" id="uploadPicture" name="profilePicture" accept="image/*" style="display: none;"></input>
          </form>
        </div>
        <h1 class="fn mediaText"><?php echo $name ?></h1>
      </header>
      <section class="contact">
        <h2>User Details</h2>
        <div class="contactMethod mediaBox"><object class="icon mediaPicture" type="image/svg+xml" data="close-envelope.svg" height="30">Email</object><p class="email mediaText"><?php echo $email?></p></div>
        <button id="editContact">Edit Info</button>
      </section>
    </div>
  </body>
</html>