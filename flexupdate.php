<?php
  require "backend/connect.php"

  //UPDATE USER STATUS AS "FLEXING" OR "OFFLINE"
  //if 'update status' button was clicked:
  if (isset($_POST['sub_status'])){

      //if user clicks "update status" and hasn't chosen an option
      if (!isset($_POST['status'])){
          echo "select a status option before updating.";
          $_POST['status'] = '';
      }
      //if user is flexing
      if ($_POST['status'] == 'flex'){
          echo "flex!";
          $prep = $dbh->prepare("UPDATE `user` SET `status` = 0 WHERE `user`.`user_id` = 1;");
          $prep->execute();
      }
      //if user is going offline
      if ($_POST['status'] == 'offline'){
          echo "offline.";
          $prep = $dbh->prepare("UPDATE `user` SET `status` = 1 WHERE `user`.`user_id` = 1;");
          $prep->execute();
      }
  }

  //UPDATE USER LOCATION
  //if 'submit location' button was clicked:
  if (isset($_POST['sub_location'])){

      //our accepted location values
      $locations = array(
      "BARH",
      "Blitman Dining Hall",
      "Commons Dining Hall",
      "DCC Cafe",
      "EMPAC Cafe (Evelyn's)",
      "Library Cafe",
      "Moe's",
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
          echo "you chose ".$current_location;

          $prep = $dbh->prepare("UPDATE `user` SET `location` = '$current_location' WHERE `user`.`user_id` = 1;");
          $prep->execute();

      }
      else{
          echo "Select a location option before updating.";
      }
  }

  //UPDATING EXCHANGE RATE
  //if user clicks "update exchange rate" button
  if (isset($_POST['sub_exchangerate'])){
      //if they didn't provide a value
      if (!isset($_POST['exchangerate'])){
          echo "Please input an exchange rate before submitting.";
      }
      //if they did provide a value
      if (isset($_POST['exchangerate'])){
          $exchange_rate = $_POST['exchangerate'];
          echo "Your exchange rate is now ".$exchange_rate;
          $prep = $dbh->prepare("UPDATE `user` SET `exchange_rate` = '$exchange_rate' WHERE `user`.`user_id` = 1;");
          $prep->execute();
      }
  }
?>

<!DOCTYPE html>
<html>
  <body>
    <!--UPDATE FLEX STATUS-->
    <form action="flexupdate.php" method="post">
        <input type="radio" name="status" value="flex"> Flex
        <input type="radio" name="status" value="offline"> Offline
        <input type="submit" name="sub_status" value="Update Status">
    </form>

    <!--CHOOSE LOCATION-->
    <form action="flexupdate.php" method="post">
      <select name="location">
        <option value="null">Please select an option..</option>
        <option value="BARH">BARH Dining Hall</option>
        <option value="Blitman Dining Hall">Blitman Dining Hall</option>
        <option value="Commons Dining Hall">Commons Dining Hall</option>
        <option value="DCC Cafe">DCC Cafe</option>
        <option value="EMPAC Cafe (Evelyn's)">EMPAC Cafe (Evelyn's)</option>
        <option value="Library Cafe">Library Cafe</option>
        <option value="Moe's">Moe's</option>
        <option value="Pittsburgh Cafe">Pittsburgh Cafe</option>
        <option value="Sage Cafe">Sage Cafe</option>
        <option value="Sage Dining Hall">Sage Dining Hall</option>
        <option value="Student Union">Student Union</option>
      </select>
      <input type="submit" name="sub_location" value="Update Location">
    </form>
    <!--CHOOSE EXCHANGE RATE-->
    <form action="flexupdate.php" method="post">
      $USD <input type="text" name="exchangerate"> per $ of FLEX
      <input type="submit" name="sub_exchangerate" value="Update Exchange Rate">
    </form>
  </body>
</html>
