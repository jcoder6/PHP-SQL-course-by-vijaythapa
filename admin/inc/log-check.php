<?php 
  // AUTHORIZATION OR ACCESS CONTROL
  // CHECK WETHER THE USER IS LOGGED IN OR NOT
  if(!isset($_SESSION['user'])){ // IF USER SESSION IS NOT SET 
    // USER IS NOT LOGGED IN
    //REDIRECT TO LOG IN PAGE WITH MESSAGE
    $_SESSION['no-login-message'] = "<div class='error'>Please log in to access ADMIN PANEL</div>";
    header('location:' .ROOT_URL. 'admin/log-in.php');
    echo "fucccccccccccccckkkkkkkkk";
  }
?>