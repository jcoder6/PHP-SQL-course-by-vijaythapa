<?php include('inc/header.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Add Admin</h1>
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
          <td><input type="text" name="full_name" placeholder="Enter your name" /></td>
        </tr>

        <tr>
          <td>Username: </td>
          <td>
            <input type="text" name="username" placeholder="Username" />
          </td>
        </tr>

        <tr>
          <td>Password: </td>
          <td>
            <input type="password" name="password" placeholder="Password" />
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
          </td>
        </tr>
      </table>

    </form>
  </div>
</div>

<?php include('inc/footer.php'); ?>

<?php
// Process the Value from form and save to DATABASE
//Check wether the submit button is clicked or not

if (isset($_POST['submit'])) {
  // Button clicked
  // echo 'Button Clicked';

  // 1. Get the data from our form
  $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, md5($_POST['password'])); //Password Encryption with md5

  // 2. SQL QUERY TO SAVE THE DATE TO DATABASE
  $sql = "INSERT INTO tbl_admin SET
            name = '$full_name',
            username = '$username',
            password = '$password'
          ";

  // 3. Execute query and save Data in DATABASE
  $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

  // 4. Check wether the (query is executed) data is inserted or not and display appropraite message
  if ($res == TRUE) {
    //DATA INSERTED
    // echo 'data inserted';
    //Create a Session Variable to Display Messages
    $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
    //Redirect the page to Manage Admin Page
    header('location:' . ROOT_URL . 'admin/manage-admin.php');
  } else {
    //data failed to insert
    // echo 'data not inserted';
    $_SESSION['add'] = 'Failed to add Admin';
    header('location:' . ROOT_URL . 'admin/manage-admin.php');
  }
}
?>