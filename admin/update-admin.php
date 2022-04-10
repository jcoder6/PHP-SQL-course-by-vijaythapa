<?php include('inc/header.php'); ?>
<?php

// GETTING THE NEW DATA INPUT BY THE USER
// Check if the connetion and pass the if the connection is success
if (isset($_POST['submit'])) {
  $newName = mysqli_real_escape_string($conn, $_POST['full_name']);
  $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
  $newPassword = mysqli_real_escape_string($conn, md5($_POST['password']));
  $adminID = mysqli_real_escape_string($conn, $_POST['update_id']);

  // echo $newName . ':' . $newUsername . ':' . $newPassword;

  $sql = "UPDATE tbl_admin SET
            name = '$newName',
            username = '$newUsername'
              WHERE id = {$adminID}";

  if (mysqli_query($conn, $sql)) {
    $_SESSION['update'] = "<div class='success'>UPDATE SUCCESSFULLY</div>";
    header('location:' . ROOT_URL . 'admin/manage-admin.php');
  } else {
    $_SESSION['update'] = "<div class='error'>FAILED TO UPDATE</div>";
    header('location:' . ROOT_URL . 'admin/manage-admin.php');
    echo 'ERROR' . mysqli_error($conn);
  }
}

//GET THE ID OF THE ADMIN THAT TO BE DELETED;
$id = $_GET['id'];
//SELECT THE ADMIN FROM THE DATABASE
$sql = "SELECT * FROM tbl_admin WHERE id=$id";

//EXECUTE THE QUERY
$res = mysqli_query($conn, $sql);

//Fetch the data we get from the result
$adminData = mysqli_fetch_assoc($res);

// Free the data we get from the fetch because it mysqli_fetch_assoc return an array;
mysqli_free_result($res);

// CLOSE THE CONNECTION BECAUSE WE ALREADY GOT THE DATA
mysqli_close($conn);
?>
<div class="main-content">
  <div class="wrapper">
    <h1>Update Admin</h1>
    <br />
    <br />

    <?php
    if (isset($_SESSION['add'])) {
      echo $_SESSION['add'];
      unset($_SESSION['add']);
    }
    ?>
    <form action="" method="POST">

      <table class="tbl-30">
        <tr>
          <td>Full Name: </td>
          <td><input type="text" name="full_name" value="<?php echo $adminData['name']; ?>" /></td>
        </tr>

        <tr>
          <td>Username: </td>
          <td>
            <input type="text" name="username" value="<?php echo $adminData['username'] ?>" />
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <input type="hidden" name="update_id" value="<?php echo $adminData['id']; ?>" />
            <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
          </td>
        </tr>
      </table>

    </form>
  </div>
</div>

<?php include('inc/footer.php'); ?>