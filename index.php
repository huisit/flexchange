<!-- Make sure the user is logged in -->
<?php 

  require_once "backend/ensureSession.php"; 
  require "backend/connect.php";

  $user_id = $_SESSION['user_id'];

  function updateFlexStatus($dbh, $user_id){

    //if user clicks "update status" and hasn't chosen an option
    if (!isset($_POST['status'])){
        echo "select a status option before updating.";
        $_POST['status'] = '';
    }
    //if user is flexing
    if ($_POST['status'] == 'flex'){
        //echo "flex!";
        $prep = $dbh->prepare("UPDATE `user` SET `status` = 0 WHERE `user`.`user_id` = $user_id;");
        $prep->execute();
    }
    //if user is going offline
    if ($_POST['status'] == 'offline'){
       // echo "offline.";
        $prep = $dbh->prepare("UPDATE `user` SET `status` = 1 WHERE `user`.`user_id` = $user_id;");
        $prep->execute();
    }

  }
  function updateLocation($dbh, $user_id){
    //our accepted location values
    $locations = array(
      "BARH",
      "Blitman Dining Hall",
      "Commons Dining Hall",
      "DCC Cafe",
      "EMPAC Cafe (Evelyns)",
      "Library Cafe",
      "Moes",
      "Pittsburgh Cafe",
      "Sage Cafe",
      "Sage Dining Hall",
      "Student Union");

      //if user clicks "update location" and hasn't chosen an option
      if (!isset($_POST['location'])){
          echo "select a location option before updating.";
          $_POST['location'] = '';
      }
      if (isset($_POST['location']) && in_array($_POST['location'], $locations)){
          $current_location = $_POST['location'];
          //echo "you chose ".$current_location;

          $prep = $dbh->prepare("UPDATE `user` SET `location` = '$current_location' WHERE `user`.`user_id` = $user_id;");
          $prep->execute();

      }
      else{
        echo "Select a location option before updating.";
      }
  }
  function updateExchangeRate($dbh, $user_id){
    //if they didn't provide a value
    if (!isset($_POST['exchangerate'])){
        echo "Please input an exchange rate before submitting.";
    }
    //if they did provide a value
    if (isset($_POST['exchangerate'])){
        $exchange_rate = $_POST['exchangerate'];
        //echo "Your exchange rate is now ".$exchange_rate;
        $prep = $dbh->prepare("UPDATE `user` SET `exchange_rate` = '$exchange_rate' WHERE `user`.`user_id` = $user_id;");
        $prep->execute();
    }
  }


  //UPDATE USER STATUS AS "FLEXING" OR "OFFLINE"
  //if 'update status' button was clicked:
  
  if (isset($_POST['sub_status'])){
    updateFlexStatus($dbh, $user_id);
  }

  //UPDATE USER LOCATION
  //if 'submit location' button was clicked:
  if (isset($_POST['sub_location'])){
    updateLocation($dbh, $user_id);
  }

  //UPDATING EXCHANGE RATE
  //if user clicks "update exchange rate" button
  if (isset($_POST['sub_exchangerate'])){
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
            <form action="index.php" method="post">
                <input type="radio" name="status" value="flex"> Flex
                <input type="radio" name="status" value="offline"> Offline
                <input type="submit" name="sub_status" value="Update Status">
            </form>
        </div>
        <div id="rate">
          <h2>Transfer Rate</h2>
            <!--CHOOSE EXCHANGE RATE-->
            <form action="index.php" method="post">
              $USD <input type="text" name="exchangerate"> per $FLEX
              <input type="submit" name="sub_exchangerate" value="Update Exchange Rate">
            </form>
        </div>
        <div id="location">
          <h2>Preferred Location</h2>
            <!--CHOOSE LOCATION-->
            <form action="index.php" method="post">
              <select name="location">
                <option value="null">Please select an option..</option>
                <option value="BARH">BARH Dining Hall</option>
                <option value="Blitman Dining Hall">Blitman Dining Hall</option>
                <option value="Commons Dining Hall">Commons Dining Hall</option>
                <option value="DCC Cafe">DCC Cafe</option>
                <option value="EMPAC Cafe (Evelyns)">EMPAC Cafe (Evelyn's)</option>
                <option value="Library Cafe">Library Cafe</option>
                <option value="Moes">Moe's</option>
                <option value="Pittsburgh Cafe">Pittsburgh Cafe</option>
                <option value="Sage Cafe">Sage Cafe</option>
                <option value="Sage Dining Hall">Sage Dining Hall</option>
                <option value="Student Union">Student Union</option>
              </select>
              <input type="submit" name="sub_location" value="Update Location">
            </form>
          </div>          
      </div>
  </body>
</html>
