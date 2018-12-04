<?php
  session_start();
  require_once "backend/connect.php";

  if (isset($_POST['valueToSearch']) && $_POST['valueToSearch'] != ""){
    $query = 'SELECT `FirstName`, `LastName`, `status`, `location`, `exchange_rate`, `email` FROM `user` WHERE CONCAT(`FirstName`, `LastName`, `status`, `location`) LIKE "%'.$_POST['valueToSearch'].'%"';
  } else {
    $query = "SELECT `FirstName`, `LastName`, `status`, `location`, `exchange_rate`, `email` FROM `user` WHERE 1";
  }
  // if (isset($_SESSION["user_id"])) {
  //   $query .= " AND `user_id` !=".$_SESSION['user_id'];
  // }
  $orderBy = array('FirstName', 'LastName', 'status', 'location', 'exchange_rate');
  if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
    $order = $_GET['orderBy'];
    $query .= " ORDER BY ".$order;
  }
  $stmt = $dbh->prepare($query);
  $stmt->execute();
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Search</title>
    <?php include("common/head.html"); ?>
    <link rel="stylesheet" type="text/css" href="style/search.css">
  </head>

  <body>
    <?php include("common/header.php");?>
    <main>
      <form id="searchForm" action="search.php" method="post">
        <input id="searchText" type="text" name="valueToSearch" placeholder="Search Users" class="form-control2">
        <input id="searchSubmit" type="submit" name="search" value="Search" class="btn"><br/>
      </form>
      <?php
        if ($stmt->rowCount() > 0) {
          echo "
            <table>
              <tr>
                <th class='firstname'><a href='?orderBy=FirstName'>First Name</a></th>
                <th class='lastname'><a href='?orderBy=LastName'>Last Name</a></th>
                <th class='status'><a href='?orderBy=status'>Flex Status</a></th>
                <th class='location'><a href='?orderBy=location'>Location</a></th>
                <th class='rate'><a href='?orderBy=exchange_rate'>\$USD/\$FLEX</a></th>
                <th class='contact'><a href='??orderBy=status'>Contact</a></th>
              </tr>
          ";
          while($row = $stmt->fetch()) {
            $status = "";
            $contactButton = "";
            if ($row['status'] == 0){
              $status = 'Flexing';
              $contactButton = "
                <form action='email.php' method='post'>
                  <input type='hidden' name='email' value=" . $row['email'] . ">
                  <input type='hidden' name='name' value=" . $row['FirstName'] . ">
                  <input type='submit' name='search' value='Exchange' class='btn'>
                </form>
              ";
            } else if ($row['status'] == 1){
              $status = 'Offline';
            } else {
              $status = 'Status Unavailable';
            }
            echo "
              <tr>
                <td>" . $row['FirstName'] . "</td>
                <td>" . $row['LastName'] . "</td>
                <td>" . $status . "</td>
                <td>" . $row['location'] . "</td>
                <td>" . $row['exchange_rate'] . "</td>
                <td>" . $contactButton . "</td>
              </tr>
            ";
          }
          echo "</table>";
        } else {
          echo "<h1>No Results</h1>";
        }
      ?>
    </main>
  </body>
</html>
