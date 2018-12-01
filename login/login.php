<?php
   // include('connect.php');
   // session_start();
   //
   // if($_SERVER["REQUEST_METHOD"] == "POST") {
   //   //username and password sent from form
   //
   //   $myusername = mysqli_real_esca

   //initialize session
   session_start();

   //check if user is logged in, if yes, redirect them to welcome page

   if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true){
     header("location: welcome.php");
     exit;
   }

   //include connection file
   require_once "connect.php";

   //define variables & init
   $email = $password = "";
   $email_err = $password_err = "";

   //processing form data when form is submitted
   if($_SERVER["REQUEST_METHOD"] == "POST"){

     //check if empty username
     if(empty(trim($_POST["email"]))){
       $email_err = "Please enter your RPI email";
     } else {
       $email = trim($_POST["email"]);
     }

     //check if empty password
     if(empty(trim($_POST["password"]))){
       $password_err = "Please enter your password";
     } else {
       $password = trim($_POST["password"]);
     }

     //validate credentials
     if(empty($email_err) && empty($password_err)){
       //prepare select statement
       $sql = "SELECT id, email, password FROM user WHERE email = ?";

       if($stmt = mysqli_prepare($link, $sql)){
         //bind variables to prepared statement as parameters
         mysqli_stmt_bind_param($stmt, "s", $param_email);

         //set parameters
         $param_email = $email;

         //attemt to execute prepared statement
         if(mysqli_stmt_execute($stmt)){

           //store result
           mysqli_stmt_store_result($stmt);

           //check if username exists, if yes, verify password
           if(mysqli_stmt_num_rows($stmt) == 1){
             //bind result variables
             mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);

             if(mysqli_stmt_fetch($stmt)){
               if(password_verify($password, $hashed_password)){
                 //pass is correct, start session
                 session_start();

                 //store data in session variables
                 $_SESSION["loggedin"] = true;
                 $_SESSION["user_id"] = $id;
                 $_SESSION["email"] = $email;

                 //Redirect to landing page
                 header("location: landing.html");
               } else {
                 //display error message
                 $password_err = "The password you entered was not valid.";
               }
             }
           } else {
             //display error msg for email
             $email_err = "No account found with that email.";
           }
         } else {
           echo "Oops! Something went wrong. Please try again later.";
         }
       }
       //close statement
       mysqli_stmt_close($stmt);

     }
     //close connection
     mysqli_close($link);

   }
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="register_style.css">
</head>

<body>

  <div class="header">
    <img src="flexchangelogo.png" width="150px"/>
  </div>

  <div class="navbar">
    <ul class="navbarlinks">
      <li><a href="login.php">Home</a></li>
      <li><a href="login.php"><img src="search.png" width="12px"> Find Flex</a><li>
    </ul>
  </div>

  <div class="wrapper">
    <h1>Login to FleXchange</h1>
    <p>Please enter your RPI email and password to login.</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
        <label>RPI email</label>
        <input type="text" name="username" class="form-control" value="<?php echo $email; ?>">
        <span class="help-block"><?php echo $email_err;?></span>
      </div>

      <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
        <span class="help-block"><?php echo $password_err;?></span>
      </div>

      <div class="form-group">
        <input type="submit" class="btn" value="LOGIN">
      </div>

      <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
  </div>
</body>
</html>
