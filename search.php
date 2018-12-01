<?php
session_start();


if (isset($_POST['search'])){
  $valueToSearch = $_POST['valueToSearch'];
  $query = "SELECT `FirstName`, `LastName`, `status`, `location`, `exchange_rate` FROM user WHERE CONCAT(`FirstName`, `LastName`, `status`, `location`) LIKE '%".$valueToSearch."%'";
  $_SESSION['LastSearch'] = $query;
  $search_result = filterTable($query);
} else {
   $query = "SELECT `FirstName`, `LastName`, `status`, `location`, `exchange_rate` FROM user";
   $search_result = filterTable($query);

}


function filterTable($query){
  $con=mysqli_connect("127.0.0.1","root","","flexchange");
  $filter_Result = mysqli_query($con, $query);
  if (!$filter_Result) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
  return $filter_Result;
}

$orderBy = array('FirstName', 'LastName', 'status', 'location', 'exchange_rate');

$order = 'type';
if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
    $order = $_GET['orderBy'];
    $query = $_SESSION['LastSearch'];
    $query .= " ORDER BY ".$order;
    $search_result = filterTable($query);

}





?>




<!DOCTYPE html>
<html>
  <head>
    <title>Search</title>
    <link rel="stylesheet" href="style/search_style.css">
    <!-- <style>
       table, tr, th, td
       {
         border: 1px solid black;
       }

    </style> -->
  </head>

  <body>
    <div class="header">
      <img src="images/flexchangelogo.png" width="150px"/>
    </div>


    <div class="navbar">
      <ul class="navbarlinks">
        <li><a href="flexupdate.php">Home</a></li>
        <li><a href="">Friends</a></li>
        <li><a href="search.php"><img src="search.png" width="12px"> Find Flex</a><li>
      </ul>
    </div>

    <div class="wrapper">

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
        <?php while($row = mysqli_fetch_array($search_result)):?>
        <tr>
          <td><?php echo $row['FirstName'];?></td>
          <td><?php echo $row['LastName'];?></td>
          <td><?php
          if ($row['status'] == 0){
            echo 'Flexing';
          }
          else if ($row['status'] == 1){
            echo 'Offline';
          }
          else{
            echo 'Status Unavailable';
          }
          ?></td>
          <td><?php echo $row['location']; ?></td>
          <td><?php echo $row['exchange_rate']; ?></td>
        </tr>
        <?php endwhile;?>



      </table>

    </form>

  </div>
  </body>
</html>
