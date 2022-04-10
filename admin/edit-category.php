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
//print_r($categData); // CHECK IF WE GET THE CORRECT DATA.

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
          <td><input type="text" name="title" placeholder="Title" value="<?php echo $title; ?>" required /></td>
        </tr>

        <tr>
          <td>Select Image: </td>
          <td><input type="file" name="image" value="<?php $imgName; ?>" /></td>
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
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Edit Category" class="btn-secondary" />
          </td>
        </tr>

      </table>

    </form>

    <!-- THE FORM START HERE -->


  </div>
</div>
<?php include('inc/footer.php'); ?>

<?php

// PUT THE RADIO INPUTS IN TO THEIR RESPECTIVE VALUES
function checkIfActive($active, $name) {
  if ($active == "Yes") {
    echo "<input type='radio' name='$name' value='Yes' checked /> Yes  ";
    echo "<input type='radio' name='$name' value='No' /> No";
  } else {
    echo "<input type='radio' name='$name' value='Yes' /> Yes  ";
    echo "<input type='radio' name='$name' value='No' checked /> No";
  }
}

if (isset($_POST['submit'])) {
  // echo "cliked submit";
  $currId = mysqli_real_escape_string($conn, $_POST['id']);
  $newTitle = mysqli_real_escape_string($conn, $_POST['title']);
  $newFeatured = mysqli_real_escape_string($conn, $_POST['featured']);
  $newActive = mysqli_real_escape_string($conn, $_POST['active']);
  // $newImgName = checkForImage();

  checkForImage($currId, $imgName);
  updateDatabase($currId, $newTitle, $newFeatured, $newActive);
  echo $currId . "---" . $newTitle . "---" . $newFeatured . "---" . $newActive . "---";
}

//CHECK THE IMAGE IS FOR UPDATES OR NOT.
function checkForImage($currId, $currImg) {
  if (isset($_FILES['image']['name'])) {
    //SET THE VALUE OF THE IMAGE
    $newImg = $_FILES['image']['name'];

    //CHECK IF THE USER IS GOING TO CHANGE THE IMAGE
    if ($newImg != "") {
      deleteCurrentImg($currImg);
      updateImage($currId, $newImg);
    }
  } else {
    return 'not update';
  }
}

//DELETE THE CURRENT IMAGE SO THAT WE CAN UPDATE THE NEW IMAGE
function deleteCurrentImg($currImg) {
  // echo $currImg;
  // DELETE THE IMAGE IN THE AND IN FOLDER
  $imgPath = "../images/category/" . $currImg;

  //CHECK IF THE IMG PATH IS VALID OR EXIST THEN DELETE THE IMAGE
  if (file_exists($imgPath)) {
    unlink($imgPath);
  }
}

//UPDATE THE IMAGE IN THE FILE AND IN THE DATABASE
function updateImage($currId, $newImg) {
  //GET THE EXTEXSION FILE TYPE OF OUR IMAGE
  $splitImageName = explode('.', $newImg);
  $imgExt = end($splitImageName);
  //RENAME OUR NEW IMAGE INTO RENAMING FORMAT THE WE HAD;
  $imgNewName = 'Food_Category_' . rand(000, 999) . '.' . $imgExt;

  $sourcePath = $_FILES['image']['tmp_name'];

  $destinationPath = '../images/category/' . $imgNewName;

  //FINALLY UPLOAD OUR NEW IMAGE INTO OUR FOLDER
  $uploadNewImg = move_uploaded_file($sourcePath, $destinationPath);

  //CREATE A QUERY THAT WILL UPDATE THE IMAGE NAME IN OUR DATABASE AND EXECUTE IT
  $query2 = "UPDATE tbl_category SET image_name = '$imgNewName' WHERE id = {$currId}";
  $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if (mysqli_query($conn, $query2) or die(mysqli_error($conn))) {
    echo "img update successfuly";
  }
}

//UPDATE THE DATA IN THE DATABASE
function updateDatabase($id, $title, $featured, $active) {
  //CREATE A QUERY THAT UPDATE THE DATA BASE
  $query3 = "UPDATE tbl_category SET
            title = '$title',
            featured = '$featured',
            active = '$active'
            WHERE id = {$id}";

  $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
  // EXECUTE THE QUERY TO FINALLY UPDATE IT AND REDIRECT TO MANAGE CATEGORY PAGE
  if (mysqli_query($conn, $query3) or die(mysqli_error($conn))) {
    $_SESSION['edited'] = "<div class='success'>CATEGORY UPDATED SUCCESSFULY</div>";
    header('location:' . ROOT_URL . 'admin/manage-category.php');
  } else {
    $_SESSION['edited'] = "<div class='error'>FAILED TO UPDATE CATEGORY</div>";
    header('location:' . ROOT_URL . 'admin/manage-category.php');
  }
}
?>