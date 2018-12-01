<?php
  require_once "backend/ensureSession.php";
  require_once "backend/connect.php";

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
    <?php
      include("common/head.html")
     ?>
    <link rel="stylesheet" type="text/css" href="profile_style.css"></link>
  </head>
  <body>
    <?php
      include("common/header.html");
    ?>
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
    <script>
      $(document).ready(function() {
        $(".editOverlay").click(function() {
          $("input[id='my_file']").click();
        });
      });
    </script>
  </body>
</html>
