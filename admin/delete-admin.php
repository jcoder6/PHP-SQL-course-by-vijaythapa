<?php

#include the constants.php file here;
include('../config/constants.php');

# 1. Get the ID of the admin to be DELETED
$id = $_GET['id'];

# 2. Create SQL Query to Delete the Admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//Execute the query;
$res = mysqli_query($conn, $sql);

//check wether the query is executed successfully or not
if ($res == TRUE) {
  //   # QUERY EXECUTED SUCCESSFULL - DELETED ADMIN
  $_SESSION['delete'] = "<div class='success'>ADMIN DELETED SUCCESSFULLY</div>";
  header('location:' . ROOT_URL . 'admin/manage-admin.php');
} else {
  //   # FAILED TO DELETE ADMIN
  $_SESSION['delete'] = "<div class='error'>FAILED TO DELETE ADMIN</div>";
  header('location:' . ROOT_URL . 'admin/manage-admin.php');
}

  # 3. Redirect to Manage Admin page with (SUCESS/ERROR)
