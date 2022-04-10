<?php include('inc/header.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Add Category</h1>

    <?php

    if (isset($_SESSION['added-categ'])) {
      echo $_SESSION['added-categ'];
      unset($_SESSION['added-categ']);
    }

    if (isset($_SESSION['upload'])) {
      echo $_SESSION['upload'];
      unset($_SESSION['upload']);
    }

    ?>
    <!-- THE FORM START HERE -->
    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-full">

        <tr>
          <td>Title: </td>
          <td><input type="text" name="title" placeholder="Title" required /></td>
        </tr>

        <tr>
          <td>Select Image: </td>
          <td><input type="file" name="image" required /></td>
        </tr>
        <tr>
          <td>Featured: </td>
          <td>
            <input type="radio" name="featured" value="Yes"> Yes
            <input type="radio" name="featured" value="No"> No
          </td>
        </tr>
        <tr>
          <td>Active: </td>
          <td>
            <input type="radio" name="active" value="Yes"> Yes
            <input type="radio" name="active" value="No"> No
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" name="submit" value="Add Category" class="btn-secondary" />
          </td>
        </tr>

      </table>

    </form>

    <!-- THE FORM START HERE -->

    <?php
    // 1. CHECK IF THE USER CLICK THE ADD CATEGORY BUTTON
    // 2. GET THE VALUES FROM THE FORM
    // FOR THE RADIO INPUTS, WE NEED TO CHECK WHETER THE BTN IS SELECTED IF NOT SET THE DEFAULT VALUE
    // FOR IMAGE INPUTS, CHECK WETHER THE IMAGE IS SELECTED OR NOT AND SET THE VALUE OF THE IMAGE ACCORDINGLY
    // 3. CREATE A SQL QUERY TO ADD DATA TO THE DATABASE
    // 4. EXECUTE THE SQL QUERY TO INSER THE DATA TO DATABASE

    // 1.
    if (isset($_POST['submit'])) {
      // echo "clicked";
      // 2.
      $title = mysqli_real_escape_string($conn, $_POST['title']);

      // for radio input,
      if (isset($_POST['featured'])) {
        $featured = mysqli_real_escape_string($conn, $_POST['featured']);
      } else {
        $featured = mysqli_real_escape_string($conn, "No");
      }

      if (isset($_POST['active'])) {
        $active = mysqli_real_escape_string($conn, $_POST['active']);
      } else {
        $active = mysqli_real_escape_string($conn, "No");
      }

      //for image inputs
      if (isset($_FILES['image']['name'])) {
        // upload the imagme;
        // to upload image we need image name, source path, and destination path.
        $imageName = $_FILES['image']['name'];

        // Auto rename the image
        // Get the extension of our image(jpg, png, gif, etc) e.g. crushkita.jpg
        $ext = end(explode('.', $imageName));

        //rename the image
        $imageName = "Food_Category_" . rand(000, 999) . "." . $ext; // e.g. Food_Category_843.jpg

        $sourcePath = $_FILES['image']['tmp_name'];

        $destinationPath = "../images/category/" . $imageName;

        // finally upload the image
        $upload = move_uploaded_file($sourcePath, $destinationPath);

        // Check wether the image is uploaded or not
        // and if the image is not uploade then we will stop the process and redirect with error message;
        if ($upload == false) {
          $_SESSION['upload'] = "<div class='error'>FAILED TO UPLOAD IMAGE</div>";
          header('location:' . ROOT_URL . 'admin/manage-category.php');
          die();
        }
      } else {
        // don't upload the image
        $imageName = "";
      }

      // 3.
      $query = "INSERT INTO tbl_category(title, featured, active, image_name) VALUES ('$title', '$featured', '$active', '$imageName')";

      // 4. 
      if (mysqli_query($conn, $query)) {
        // echo "DATA INSERTED";
        $_SESSION['added-categ'] = "<div class='success'>CATEGORY ADDED SUCCESSFULY</div>";
        header('location:' . ROOT_URL . 'admin/manage-category.php');
      } else {
        // echo "DATA NOT INSERTED";
        $_SESSION['added-categ'] = "<div class='erorr'>FAILED TO ADD CATEGORY</div>";
        header('location:' . ROOT_URL . 'admin/manage-category.php');
      }
    }

    ?>
  </div>
</div>


<?php include('inc/footer.php'); ?>