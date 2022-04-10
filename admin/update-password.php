<?php include('inc/header.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Change Password</h1>
    <?php

    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    }
    ?>
    <br><br>
    <form action="" method="POST">

      <table class="tbl-30">
        <tr>
          <td>Current Password: </td>
          <td><input type="password" name="current-password" placeholder="Current Password"></td>
        </tr>

        <tr>
          <td>New Password: </td>
          <td><input type="password" name="new-password" placeholder="New Passoword"></td>
        </tr>

        <tr>
          <td>Confirm Password: </td>
          <td><input type="password" name="confirm-password" placeholder="Confirm Password"></td>
        </tr>
      </table>

      <tr>
        <td colspan="2">
          <input type="hidden" name="admin-id" value="<?php echo $id; ?>">
          <input type="submit" name="submit" value="Change Password" class="btn-secondary">
        </td>
      </tr>
    </form>
  </div>
</div>

<?php
// CHECK IF THE USER CLICKED SUBMIT
if (isset($_POST['submit'])) {
  // echo "SUBMIT";

  // GET DATA FROM THE FORM;
  $id = mysqli_real_escape_string($conn, $_POST['admin-id']);
  $currentPass = mysqli_real_escape_string($conn, md5($_POST['current-password']));
  $newPass = mysqli_real_escape_string($conn, md5($_POST['new-password']));
  $confirmPass = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));

  // echo $id . "-" . $currentPass . "-" . $newPass . "-" . $confirmPass;

  //CREATE QUERY
  $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$currentPass'";

  //get the result from the query
  $res = mysqli_query($conn, $sql);

  //Count of the data we get it should be only 1
  $count = mysqli_num_rows($res);

  //fetch the result from the result data
  $adminData = mysqli_fetch_assoc($res);

  //Free the result
  mysqli_free_result($res);

  //close the connection
  //Check if the id and current pass are match
  if ($adminData['id'] == $id && $adminData['password'] == $currentPass && $count == 1) {
    if ($newPass == $confirmPass) {
      // echo 'password match';

      //update Password to the new password
      // 1. create the query that's update a password to database
      $sql = "UPDATE tbl_admin SET
              password = '$newPass'
               WHERE password = '$currentPass'";
      // 2. execute the query;
      $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      if ($res == TRUE) {
        $_SESSION['update-pass'] = "<div class='success'>PASSWORD CHANGED SUCCESSFULY</div>";
        header('location:' . ROOT_URL . 'admin/manage-admin.php');
      } else {
        echo 'ERROR' . mysqli_error($conn);
      }
    } else {
      $_SESSION['user-not-found'] = "<div class='error'>PASSWORD DOES NOT MATCH</div>";
      header('location:' . ROOT_URL . 'admin/manage-admin.php');
    }
  } else {
    $_SESSION['user-not-found'] = "<div class='error'>USER NOT FOUND </div>";
    header('location:' . ROOT_URL . 'admin/manage-admin.php');
  }

  mysqli_close($conn);
}
?>

<?php include('inc/footer.php'); ?>