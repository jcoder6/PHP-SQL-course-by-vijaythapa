<?php include('../config/constants.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/admin.css">
  <title>Log in Admin</title>
</head>
<body>
  <div class="log-in">
    <h1 class ="text-center">LOG IN</h1><br><br>

    <?php
      if(isset($_SESSION['login'])){
        echo $_SESSION['login'];
        unset($_SESSION['login']);
      }

      if(isset($_SESSION['no-login-message'])){
        echo $_SESSION['no-login-message'];
        unset($_SESSION['no-login-message']);
      }
    ?>
    <!-- LOG IN FORM STARTS HERE -->
    <form action="" method="POST">
      <label for="username">Username</label><br>
      <input type="text" name="username" placeholder="Enter username" />
      <br><br>
      
      <label for="password">Password</label><br>
      <input type="password" name="password" placeholder="Enter password" />
      <br><br>
      <input type="submit" name="submit" value="Log In" class="btn-primary">
      <br><br>
      <br><br>
    </form>
    <!-- LOG IN FORM END HERE -->
    <p class ="text-center" >Created by: <a href="https://www.youtube.com/playlist?list=PLBLPjjQlnVXXBheMQrkv3UROskC0K1ctW">Vijay Thapa PHP and SQL series</a></p>
  </div>
</body>
</html>

<?php

  // CHECK IF THE SUBMIT BTN IS CLICKED
  if(isset($_POST['submit'])){
    // PROCESS FOR LOG IN.

    // 1. GET THE DATA FROM THE LOG IN FORM
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    // 2. SQL QUERY TO CHECK WETHER THE USER NAME AND PASSWORD EXIST OR NOT
    $query = "SELECT * FROM tbl_admin
            WHERE username = '$username'
            AND password = '$password'";

    // 3. GET THE RESULT FROM THE DATABASE
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    // 4. COUNT THE DATA THAT THE DATABASE RETURN IT SHOULD 1 ONLY
    $count = mysqli_num_rows($res);
    
    if($count == 1){
      $_SESSION['login'] = "<br><div class='success'>LOG IN SUCCESSFULL</div><br>";
      $_SESSION['user'] = $username; // to check wether the user is logged in or not and logout will unset it.
      header('location:' .ROOT_URL. 'admin/');
    } else {
      $_SESSION['login'] = "<div class='error'>INCORRECT USERNAME OR PASSWORD</div><br>";
      header('location:' .ROOT_URL. 'admin/log-in.php');
    }
  }
?>