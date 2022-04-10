<?php include('inc/header.php'); ?>
<div class="main-content">
  <div class="wrapper">
    <h1>Manage Admin</h1>

    <?php
    # Message ADMIN ADDED
    if (isset($_SESSION['add'])) {
      echo $_SESSION['add']; //DISPLAYING SESSION MESSAGE
      unset($_SESSION['add']); // UNDSIPLAYING SESSION MESSAGE
    }

    if (isset($_SESSION['delete'])) {
      echo $_SESSION['delete'];
      unset($_SESSION['delete']);
    }

    if (isset($_SESSION['update'])) {
      echo $_SESSION['update'];
      unset($_SESSION['update']);
    }

    if (isset($_SESSION['user-not-found'])) {
      echo $_SESSION['user-not-found'];
      unset($_SESSION['user-not-found']);
    }

    if (isset($_SESSION['update-pass'])) {
      echo $_SESSION['update-pass'];
      unset($_SESSION['update-pass']);
    }
    ?>
    <!-- Button to Admin -->
    <br />
    <br />
    <a href="add-admin.php" class="btn-primary">Add Admin</a>
    <br />
    <br />

    <table class="tbl-full">
      <tr>
        <th>S.N.</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>Actions</th>
      </tr>


      <?php
      //QUERY TO GET ALL THE ADMIN IN THE DATABASE
      $sqlQuery = "SELECT * FROM tbl_admin";
      //EXECUTE THE QUERY
      $resQuery = mysqli_query($conn, $sqlQuery);

      //Check wether the query is executed or not
      if ($resQuery == TRUE) {
        //COUNT ROWS WETHER WE DATA IN DATABASE OR NOT
        $count = mysqli_num_rows($resQuery); // function get all the rows in the database

        //CHECK THE NUMBERS OF ROWS
        if ($count > 0) {
          // we have data in database
          $serialNumber = 0;
          while ($rows = mysqli_fetch_assoc($resQuery)) {
            //using while loop to get all the data from database.
            //and while loop will run as long as we have data in database

            //get individual data
            $serialNumber++;
            $id = $rows['id'];
            $full_name = $rows['name'];
            $username = $rows['username'];

            // Display the values in our table

      ?>
            <tr>
              <td><?php echo $serialNumber; ?></td>
              <td><?php echo $full_name; ?></td>
              <td><?php echo $username; ?></td>
              <td>
                <a href="<?php echo ROOT_URL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                <a href="<?php echo ROOT_URL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                <a href="<?php echo ROOT_URL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
              </td>
            </tr>
      <?php
          }
        }
      }

      ?>
    </table>
  </div>
</div>
<?php include('inc/footer.php'); ?>