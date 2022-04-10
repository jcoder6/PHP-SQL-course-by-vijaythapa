<?php
  //INCLUDE THE ROOT URL WHICH IS LOCATED IN CONTANTS.PHP FILE.
  include('../config/constants.php');
  //1. destory all the session we created in the page
    session_destroy(); // unsets $_SESSION['user'];

  //2. redirect the page to log-in page;
  header('location:' .ROOT_URL. 'admin/log-in.php');
