<?php
  session_start();
  //Create Constants TO STORE REPEATING VALUES
  define('ROOT_URL', 'http://localhost/food-order-phpCourse/');
  define('LOCALHOST', 'localhost');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', 'sqlpassword123');
  define('DB_NAME', 'food-order');

  $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME); // CONNECT TO THE DATABASE

  if(mysqli_connect_errno()){
    echo 'Connection error' . mysqli_connect_errno();
  }

?>