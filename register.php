<?php
   //connection
   require_once "backend/connect.php";

   //define variables and initialize with empty values
   $email = $password = $confirm_password = $FirstName = $LastName = "";
   $email_err = $password_err = $confirm_password_err = $FirstName_err = $LastName_err = "";

   //processing form data
   if($_SERVER["REQUEST_METHOD"] == "POST"){

     //validate first name
     if(empty(trim($_POST["FirstName"]))){
       $FirstName_err = "Please enter your preferred first name.";
     } else {
       $FirstName = trim($_POST["FirstName"]);
     }

     //validate last name
     if(empty(trim($_POST["LastName"]))){
       $LastName_err = "Please enter your last name.";
     } else {
       $LastName = trim($_POST["LastName"]);
     }

     //validate username
     if(empty(trim($_POST["email"]))){
       $email_err = "Please enter your RPI email. ";
     } else {
       //Prepare select statement, users sign up with email
       $sql = "SELECT id FROM users WHERE email = ?";

       if($stmt = mysqli_prepare($link, $sql)){
         // Bind variables to the prepared statement as parameters
         mysqli_stmt_bind_param($stmt, "s", $param_email);

         //set parameters
         $param_email = trim($_POST["email"]);

         //attempt to execute prepared statement
         if(mysqli_stmt_execute($stmt)){
           //store result
           mysqli_stmt_store_result($stmt);

           if(mysqli_stmt_num_rows($stmt) == 1){
             $email_err = "This email is already in use.";
           } else {
             $email = trim($_POST["email"]);
           }
         } else {
           echo "Oops! Something went wrong. Try again later.";
         }
       }
       //close PDOStatement
       mysqli_stmt_close($stmt);
     }

     //validate password
     if(empty(trim($_POST["password"]))){
       $password_err = "Please enter a password. ";
     } elseif(strlen(trim($_POST["password"])) < 6){
       $password_err = "Password must have at least 6 characters. ";
     } else {
       $password = trim($_POST["password"]);
     }


     //validate confirm Password
     if(empty(trim($_POST["confirm_password"]))){
       $confirm_password_err = "Please confirm password. ";
     } else {
       $confirm_password = trim($_POST["confirm_password"]);

       if(empty($password_err) && ($password != $confirm_password)){
         $confirm_password_err = "Password did not match.";
       }
     }

// ----------------------------------------------------
// Check input errors before inserting in database

    if(empty($FirstName_err) && empty($LastName_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)){

      //Prepare insert statement
      $sql = "INSERT INTO user (FirstName, LastName, email, pass_hash) VALUES (?, ?, ?,?)";

      if($stmt = mysqli_prepare($link, $sql)){

        //Bind variables to prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssss", $param_FirstName, $param_LastName, $param_email, $param_password);

        //set parameters
        $param_FirstName = $FirstName;
        $param_LastName = $LastName;
        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT); //creates pass hash

        //Attempt execute prepared statement
        if(mysqli_stmt_execute($stmt)){
          //Redirect to login page
          header("location: login.php");
        } else{
          echo "Something went wrong. Please try again later.";
        }
      }

      //Close statement
      mysqli_stmt_close($stmt);
    }

    //Close connection
    mysqli_close($link);
   }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up</title>
  <link rel="stylesheet" href="style/register_style.css">
  <?php
    include("common/head.html");
  ?>
</head>
<body>
  <?php
    include("common/header.html");
  ?>

  <main>
    <h1>Sign up for FleXchange</h1>
    <p>Please enter your details.</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

      <div class="form-group <?php echo (!empty($FirstName_err)) ? 'has error' : ''; ?>">
        <label for="FirstName" class="_label">First Name</label>
        <input type="text" name="FirstName" class="form-control" value="<?php echo $FirstName; ?>">
        <span class="help-block"><?php echo $FirstName_err; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($LastName_err)) ? 'has error' : ''; ?>">
        <label for="LastName" class="_label">Last Name</label>
        <input type="text" name="LastName" class="form-control" value="<?php echo $LastName; ?>">
        <span class="help-block"><?php echo $LastName_err; ?></span>
      </div>


      <div class="form-group <?php echo (!empty($username_err)) ? 'has error' : ''; ?>">
        <label for="email" class="_label">RPI Email</label>
        <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
        <span class="help-block"><?php echo $email_err; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <label for="password" class="_label">Password</label>
        <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
        <span class="help-block"><?php echo $password_err; ?></span>
      </div>

      <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
        <label for="confirm_password" class="_label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
        <span class="help-block"><?php echo $confirm_password_err; ?></span>
      </div>

      <div class="form-group">
        <input type="submit" class="btn" value="START FLEXING">
        <input type="reset" class="btn" value="RESET">
      </div>

      <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
  </main>
</body>
</html>
