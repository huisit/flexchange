<?php
  session_start();

  require "backend/connect.php";

  if (isset($_POST['search'])){
    $valueToSearch = $_POST['valueToSearch'];
    $query = "SELECT `FirstName`, `LastName`, `status`, `location`, `exchange_rate` FROM user WHERE CONCAT(`FirstName`, `LastName`, `status`, `location`) LIKE '%:value%'";
    $query = setOrder($query);
    print_r($query);
    $stmt = $dbh->prepare($query);
    $stmt->execute(['value' => $valueToSearch]);
  } else {
    $query = "SELECT `FirstName`, `LastName`, `status`, `location`, `exchange_rate` FROM user";
    $query = setOrder($query);
    $stmt = $dbh->prepare($query);
    $stmt->execute();
  }

  function setOrder($query) {
    $orderBy = array('FirstName', 'LastName', 'status', 'location', 'exchange_rate');
    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
      $order = $_GET['orderBy'];
      $query .= " ORDER BY ".$order;
    }
    return $query;
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Search</title>
    <?php
      include("common/head.html");
    ?>
    <link rel="stylesheet" type="text/css" href="style/search_style.css">
  </head>

  <body>
    <?php
      include("common/header.html");
    ?>

    <form action="search.php" method="post">
      <input type="text" name="valueToSearch" placeholder="Search Users" class="form-control"><br>
      <input type="submit" name="search" value="Search" class="btn"><br><br>

      <table>
        <tr>
          <th class="firstname"><a href="?orderBy=FirstName">First Name</a> </th>
          <th class="lastname"><a href="?orderBy=LastName">Last Name</a></th>
          <th class="status"><a href="?orderBy=status">Flex Status</a></th>
          <th class="location"><a href="?orderBy=location">Location</a></th>
          <th class="rate"><a href="?orderBy=exchange_rate">Exchange Rate ($USD/$FLEX)</a></th>

        </tr>
        <?php
          while($row = $stmt->fetch()) {
            $status = "";
            if ($row['status'] == 0){
              $status = 'Flexing';
            }
            else if ($row['status'] == 1){
              $status = 'Offline';
            }
            else{
              $status = 'Status Unavailable';
            }
            $htmlString = "
              <tr>
                <td>" . $row['FirstName'] . "</td>
                <td>" . $row['LastName'] . "</td>
                <td>" . $status . "</td>
                <td>" . $row['location'] . "</td>
                <td>" . $row['exchange_rate'] . "</td>
              </tr>";
            echo $htmlString;
          }
        ?>
      </table>
    </form>
  </body>
</html>
