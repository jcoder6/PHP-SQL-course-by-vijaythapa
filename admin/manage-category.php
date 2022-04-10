<?php include('inc/header.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Manage Category</h1>

    <!-- Button to Admin -->
    <br />
    <br />
    <a href="add-category.php" class="btn-primary">Add Category</a>
    <br />
    <br />

    <?php
    if (isset($_SESSION['added-categ'])) {
      echo $_SESSION['added-categ'];
      unset($_SESSION['added-categ']);
    }

    if (isset($_SESSION['upload'])) {
      echo $_SESSION['upload'];
      unset($_SESSION['upload']);
    }

    if (isset($_SESSION['delete'])) {
      echo $_SESSION['delete'];
      unset($_SESSION['delete']);
    }
    ?>
    <table class="tbl-full">
      <tr>
        <th>S.N.</th>
        <th>Title</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Action</th>
        <th>Actions</th>
      </tr>

      <!-- <tr>
          <td>1.</td>
          <td>Jomer Dorego</td>
          <td>jdorego06</td>
          <td>
            <a href="#" class="btn-secondary">Update Admin</a> 
            <a href="#" class="btn-danger">Delete Admin</a>
          </td>
        </tr>

        <tr>
          <td>2.</td>
          <td>Jomer Dorego</td>
          <td>jdorego06</td>
          <td>
            <a href="#" class="btn-secondary">Update Admin</a> 
            <a href="#" class="btn-danger">Delete Admin</a>
          </td>
        </tr>

        <tr>
          <td>3.</td>
          <td>Jomer Dorego</td>
          <td>jdorego06</td>
          <td>
            <a href="#" class="btn-secondary">Update Admin</a> 
            <a href="#" class="btn-danger">Delete Admin</a>
          </td> 
        </tr> -->

      <?php
      // 1. CREATE A SQL QUERY THAT WILL GET ALL THE CATEGORIES FROM THE DATABASE
      // 2. EXECUTE THE QUERY TO GET THE RESULT FROM THE DATA BASE
      // 3. FETCH THE DATA FROM THE RESULT TO STORE IT IN A VARIABLE.
      // 4. PUT EACH DATA TO VARIABLE SO WE CAN USE IT FROM OUR HTML.

      //1.
      $query = "SELECT * FROM tbl_category";

      // 2.
      $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
      // 3.
      $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
      // free the result
      mysqli_free_result($res);

      // print_r($categories);
      $serialNum = 0;
      ?>

      <?php foreach ($categories as $categ) : $serialNum++ ?>
        <tr>
          <td><?php echo $serialNum; ?></td>
          <td><?php echo $categ['title']; ?></td>
          <td>
            <?php
            if ($categ['image_name'] != "") {
              $imgPath = ROOT_URL . "images/category/" . $categ['image_name'];
            ?>
              <img src="<?php echo $imgPath; ?>" alt="<?php echo $categ['image_name']; ?>" width="100px">
            <?php
            } else {
              echo "<div class='error'>Image is currently not available</div>";
            }
            ?>

          </td>
          <td><?php echo $categ['featured']; ?></td>
          <td><?php echo $categ['active']; ?></td>

          <td>
            <a href="<?php echo ROOT_URL; ?>admin/edit-category.php?id=<?php echo $categ['id']; ?>" class="btn-secondary">Edit Category</a>
            <a href="<?php echo ROOT_URL; ?>admin/delete-category.php?id=<?php echo $categ['id']; ?>" class="btn-danger">Delete Category</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>

<?php include('inc/footer.php'); ?>