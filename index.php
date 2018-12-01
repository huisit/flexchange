<?php
  require_once "backend/ensureSession.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Flexchange</title>
    <?php
      include("common/head.html");
    ?>
  </head>

  <body>
    <?php
      include("common/header.php");
    ?>
    <div>
      <h1 style="color: #832E2B; margin: 50px">Welcome back, <?php echo $_SESSION['FirstName']?></h1>
    </div>
    <div id="container">
      <div id="status">
        <h2>ONLINE STATUS</h2>
        <div class="dropdown">
          <button class="dropbtn">Dropdown</button>
          <div class="dropdown-content">
            <a href="#">Link 1</a>
            <a href="#">Link 2</a>
            <a href="#">Link 3</a>
          </div>
        </div>
      </div>
      <div id="rate">
        <h2>TRANSFER RATE</h2>
      </div>
      <div id="location">
        <h2>PREFERRED LOCATION</h2>
      </div>
    </div>
  </body>
</html>
