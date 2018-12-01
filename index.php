<!-- Make sure the user is logged in -->
<!DOCTYPE html>
<html>
  <head>
    <title>Flexchange</title>
    <!-- Common head data -->
    <?php include("common/head.html"); ?>
  </head>

  <body>
    <?php include("common/header.php"); ?>
    <h1 style="color: #832E2B; margin: 50px">Welcome back, <?php echo $_SESSION['FirstName']?></h1>
    <div id="container">
      <div id="status">
        <h2>Online Status</h2>
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
        <h2>Transfer Rate</h2>
      </div>
      <div id="location">
        <h2>Preffered Location</h2>
      </div>
    </div>
  </body>
</html>
