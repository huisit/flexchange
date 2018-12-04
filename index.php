<?php
  //Make sure the user is logged in
  require_once "backend/ensureSession.php";
  require "backend/connect.php";

  $user_id = $_SESSION['user_id'];

  //Get current status
  $status_stmt = $dbh->prepare("SELECT `status`, `location`, `exchange_rate` FROM `user` WHERE `user_id` = :id");
  $status_stmt->execute(['id' => $user_id]);
  $status_info = $status_stmt->fetch();
  $status = $status_info['status'];
  $location = $status_info['location'];
  $exchange_rate = $status_info['exchange_rate'];

  function updateFlexStatus($dbh, $user_id) {
    //if user clicks "update status" and hasn't chosen an option
    if (!isset($_POST['status'])) {
        echo "select a status option before updating.";
        $_POST['status'] = '';
    }
    //if user is flexing
    if ($_POST['status'] == 'flex') {
        //echo "flex!";
        $prep = $dbh->prepare("UPDATE `user` SET `status` = 0 WHERE `user`.`user_id` = $user_id;");
        $prep->execute();
    }
    //if user is going offline
    if ($_POST['status'] == 'offline') {
       // echo "offline.";
        $prep = $dbh->prepare("UPDATE `user` SET `status` = 1 WHERE `user`.`user_id` = $user_id;");
        $prep->execute();
    }
  }

  function updateLocation($dbh, $user_id) {
      //if user clicks "update location" and hasn't chosen an option
      if (isset($_POST['location'])) {
        $prep = $dbh->prepare("UPDATE `user` SET `location` = :loc WHERE `user`.`user_id` = :id;");
        $prep->execute(['loc' => $_POST['location'], 'id' => $_SESSION['user_id']]);
      } else {
        echo "Select a location option before updating.";
      }
  }
  function updateExchangeRate($dbh, $user_id) {
    //if they didn't provide a value
    if (!isset($_POST['exchangerate'])){
        echo "Please input an exchange rate before submitting.";
    }
    //if they did provide a value
    if (isset($_POST['exchangerate'])) {
        $exchange_rate = $_POST['exchangerate'];
        //echo "Your exchange rate is now ".$exchange_rate;
        $prep = $dbh->prepare("UPDATE `user` SET `exchange_rate` = '$exchange_rate' WHERE `user`.`user_id` = $user_id;");
        $prep->execute();
    }
  }

  //UPDATE USER STATUS AS "FLEXING" OR "OFFLINE"
  //if 'update status' button was clicked:
  if (isset($_POST['sub_status'])) {
    updateFlexStatus($dbh, $user_id);
  }

  //UPDATE USER LOCATION
  //if 'submit location' button was clicked:
  if (isset($_POST['sub_location'])) {
    updateLocation($dbh, $user_id);
  }

  //UPDATING EXCHANGE RATE
  //if user clicks "update exchange rate" button
  if (isset($_POST['sub_exchangerate'])) {
    updateExchangeRate($dbh, $user_id);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Flexchange</title>
    <!-- Common head data -->
    <?php include("common/head.html"); ?>
  </head>

  <body>
    <?php include("common/header.php"); ?>
    <h1 style="color: #832E2B; margin: 50px">Welcome back,
        <?php
        $fname = $_SESSION['FirstName'];
        $lname = $_SESSION['LastName'];
        echo "$fname $lname."
       ?>
    </h1>
    <div id="container">
        <div id="status">
          <h2>Online Status</h2>
            <!--UPDATE FLEX STATUS-->
            <form action="index.php" method="post" id="statusForm">
              <input type="radio" name="status" value="flex" class="form-radio" <?php if($status==0) echo "checked" ?>>FLEXING
              <input type="radio" name="status" value="offline" class="form-radio" <?php if($status==1) echo "checked" ?>>OFFLINE
              <input type="submit" name="sub_status" value="Update Status" class="btn2">
            </form>
        </div>
        <div id="rate">
          <h2>Transfer Rate</h2>
            <!--CHOOSE EXCHANGE RATE-->
            <form action="index.php" method="post" id="statusForm">
              <label for="exchangerate">$USD to FLEX</label><input type="text" name="exchangerate" class="form-control" value='<?php echo $exchange_rate ?>' placeholder="ex. $0.50 / 1 FLEX">
              <input type="submit" name="sub_exchangerate" value="Update Exchange Rate" class="btn2">
            </form>
        </div>
        <div id="location">
          <h2>Preferred Location</h2>
            <!--CHOOSE LOCATION-->
          <div class="styled-select semi-square">
            <form action="index.php" method="post">
              <select name="location" class="custom-select" style="width:220px;">
                <option value="null">Please select an option..</option>
                <?php
                  $locations = [
                    'BARH', 'Blitman Dining Hall', 'Commons Dining Hall', 'DCC Cafe',
                    'EMPAC Cafe (Evelyns)', 'Library Cafe', 'Moes', 'Pittsburgh Cafe',
                    'Sage Cafe', 'Sage Dining Hall', 'Student Union'
                  ];
                  print_r($location);
                  for ($i = 0; $i < sizeof($locations); $i++) {
                    $selected = "";
                    if($location == $locations[$i]) {
                      $selected = "selected";
                    }
                    echo '<option ' . $selected . ' value=' . $locations[$i] . '>' . $locations[$i] . '</option>';
                  }
                ?>
              </select>
              </div>
              <input type="submit" name="sub_location" value="Update Location" class="btn2">
            </form>
          </div>
      </div>
  </body>
</html>
