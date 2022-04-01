<?php include('inc/header.php'); ?>
<?php 

  //GET THE ID OF THE CATEGORY THAT WILL BE EDITED
  $id = $_GET['id'];
  
  //CREATE A QUERY WHERE WE SELECT ONLY THE CATEGORY WE WANT TO EDIT
  $query = "SELECT * FROM tbl_category WHERE id = $id";

  //EXECUTE THE QUERY SO THAT WE GET THE DATA WE'VE ALWAYS WANTED;
  $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

  //FECTH THE DATA WE GET FROM THE EXECUTION OF THE RESULT;
  $categData = mysqli_fetch_assoc($res);

  //FREE THE RESULT WE GET FROM THE EXECUTION OF THE QUERY;
  mysqli_free_result($res);
  print_r($categData); // CHECK IF WE GET THE CORRECT DATA.

  //GET EACH DATA AND STORE IT IN A VARIABLE
  $id = $categData['id'];
  $title = $categData['title'];
  $imgName = $categData['image_name'];
  $featured = $categData['featured'];
  $active = $categData['active'];

?>
  <div class="main-content">
    <div class="wrapper">

      <!-- THE FORM START HERE -->
      <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-full">

          <tr>
            <td>Title: </td>
            <td><input type="text" name="title" placeholder="Title" value="<?php echo $title; ?>" required/></td>
          </tr>

          <tr>
            <td>Select Image: </td>
            <td><input type="file" name="image" required/></td>
          </tr>
          <tr>
            <td>Featured: </td>
            <td>
              <?php checkIfActive($featured, 'featured'); ?>
            </td>
          </tr>
          <tr>
            <td>Active: </td>
            <td>
              <?php checkIfActive($active, 'active'); ?>
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


    </div>
  </div>
<?php include('inc/footer.php'); ?>

<?php 

  function checkIfActive($active, $name){
    if($active == "Yes"){
      echo "<input type='radio' name='$name' value='Yes' checked /> Yes  ";
      echo "<input type='radio' name='$name' value='No' /> No" ;
    } else {
      echo "<input type='radio' name='$name' value='Yes' /> Yes  ";
      echo "<input type='radio' name='$name' value='No' checked /> No" ;
    }
  }

?>