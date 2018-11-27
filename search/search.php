<?php
session_start();


if (isset($_POST['search'])){
  $valueToSearch = $_POST['valueToSearch'];
  $query = "SELECT * FROM user WHERE CONCAT(`FirstName`, `LastName`, `status`) LIKE '%".$valueToSearch."%'";
  $_SESSION['LastSearch'] = $query;
  $search_result = filterTable($query);


} else {
   $query = "SELECT * FROM user";
   $search_result = filterTable($query);

}


function filterTable($query){
  $con=mysqli_connect("127.0.0.1","root","","flexchange");
  $filter_Result = mysqli_query($con, $query);
  return $filter_Result;
}

$orderBy = array('FirstName', 'LastName', 'status');

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
    <style>
       table, tr, th, td
       {
         border: 1px solid black;
       }

    </style>
  </head>

  <body>
    <form action="search.php" method="post"> 
      <input type="text" name="valueToSearch" placeholder="Search Users"><br><br>
      <input type="submit" name="search" value="Search"><br><br>

      <table>
        <tr>
          <th><a href="?orderBy=FirstName">First Name</a> </th>
          <th><a href="?orderBy=LastName">Last Name</a></th>
          <th><a href="?orderBy=status">Flex Status</a></th>

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
        </tr>
        <?php endwhile;?>



      </table>

    </form>
  </body>
</html>
