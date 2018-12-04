<?php
  require_once "backend/ensureSession.php"; //Ensure the user is logged in
  require_once "backend/connect.php"; //Connect to the database

  //Get the user's information to display
  if (isset($_POST['firstname'])) {
    $stmt = $dbh->prepare("UPDATE user SET FirstName = :firstname WHERE user_id = :id");
    $stmt->execute(['firstname' => $_POST['firstname'], 'id' => $_SESSION['user_id']]);
    $_SESSION['FirstName'] = $_POST['firstname'];
  }
  if (isset($_POST['lastname'])) {
    $stmt = $dbh->prepare("UPDATE user SET LastName = :lastname WHERE user_id = :id");
    $stmt->execute(['lastname' => $_POST['lastname'], 'id' => $_SESSION['user_id']]);
    $_SESSION['LastName'] = $_POST['lastname'];
  }
  if (isset($_POST['email'])) {
    //first check to see if we've already got that email
    $prep = $dbh->prepare("SELECT * FROM user WHERE `email` = :email");
    $prep->execute(['email' => $_POST['email']]);
    $check = $prep->fetch(PDO::FETCH_ASSOC);
    if ($check === TRUE){
      $msg = "An account with that email already exists.";
    } else {
      $stmt = $dbh->prepare("UPDATE user SET email = :email WHERE user_id = :id");
      $stmt->execute(['email' => $_POST['email'], 'id' => $_SESSION['user_id']]);
      $_SESSION['email'] = $_POST['email'];
    }
  }
  if (isset($_POST['pass'])) {
    //Ensure correct password entered
    $salt_stmt = $dbh->prepare('SELECT pass_salt FROM user WHERE user_id = :id');
    $salt_stmt->execute([':id' => $_SESSION['user_id']]);
    $res = $salt_stmt->fetch();
    $salt = ($res) ? $res['pass_salt'] : '';
    $salted = hash('sha256', $salt . $_POST['pass']);
    $verify_stmt = $dbh->prepare('SELECT user_id FROM user WHERE pass_hash = :pass');
    $verify_stmt->execute([':pass' => $salted]);
    if ($_SESSION['user_id'] != $verify_stmt->fetch()) {
      $msg = "Old password is incorrect";
    } else {
      // Generate random salt
      $salt = hash('sha256', uniqid(mt_rand(), true));
      // Apply salt before hashing
      $salted = hash('sha256', $salt . $_POST['pass']);

      $stmt = $dbh->prepare("UPDATE user SET pass = :pass WHERE user_id = :id");
      $stmt->execute(['pass' => $salted, 'id' => $_SESSION['user_id']]);
    }
  }
?>

<html>
  <head>
    <?php include("common/head.html") ?>
  </head>
  <body>
    <?php include("common/header.php"); ?>
    <main>
      <h1>User Details</h1>
      <?php
        $pictureLocation = "profilePictures/" . $_SESSION['user_id'] . ".png";
        if (!file_exists($pictureLocation)) {
          $pictureLocation = "profilePictures/default.png";
        }
        echo "<img class='photo circleFrame mediaPicture' src='" . $pictureLocation . "' width='100'></img>";
      ?>
      <br>
      <form action="uploadPicture.php" method="post" enctype="multipart/form-data">
        <input type="file" name="profilePicture" accept="image/*" onchange="form.submit()"></input>
      </form>
      <?php if (isset($msg)) echo "<strong>$msg</strong>" ?>
      <form method="post" action="profile.php">
        <label for="firstname">First Name: </label><input type="text" name="firstname" class="form-control" value="<?php echo $_SESSION['FirstName']; ?>"/>
        <label for="lastname">Last Name: </label><input type="text" name="lastname" class="form-control" value="<?php echo $_SESSION['LastName']; ?>"/>
        <label for="email">RPI Email: </label><input type="text" name="email" class="form-control" value="<?php echo $_SESSION['email']; ?>"/>
        <label for="pass">Old Password: </label><input type="password" name="pass" class="form-control" />
        <label for="passconfirm">New Password: </label><input type="password" name="newpass" class="form-control" />
        <br>
        <input type="submit" name="update" value="Update Information" class="btn"/>
      </form>
    </main>
  </body>
</html>
