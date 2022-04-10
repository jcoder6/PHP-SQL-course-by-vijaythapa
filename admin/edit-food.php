<?php include('inc/header.php'); ?>
<?php
//get the food id in our url
$id = $_GET['id'];

//Create a query that will get the editing data to the database
$query = "SELECT * FROM tbl_food WHERE id = $id";

//execute the query to get the result from the database
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

//fetcht the result in the sqli query so the we can use data in our webpage
$food = mysqli_fetch_assoc($res);

// free the result from the query
mysqli_free_result($res);

// print_r($food);
// echo $food['title'];
?>

<div class="main-content">
  <div class="wrapper">
    <h1>Edit Food</h1>
    <form action="" method="POST" enctype="multipart/form-data">
      <table class="tbl-full">
        <tr>
          <td>Title: </td>
          <td><input type="text" name="title" placeholder="Title" value="<?php echo $food['title']; ?>" /></td>
        </tr>

        <tr>
          <td>Price: </td>
          <td><input type="number" name="price" placeholder="Price" value="<?php echo $food['price']; ?>" /></td>
        </tr>

        <tr>
          <td>Description: </td>
          <td><textarea name="description" placeholder='description...' cols="30" rows="5"><?php echo $food['description']; ?></textarea></td>
        </tr>

        <tr>
          <td>Image: </td>
          <td><input type="file" name="image" /></td>
        </tr>

        <tr>
          <td>Category</td>
          <td>
            <select name="category">
              <?php displayCategories($conn); ?>
            </select>
          </td>
        </tr>

        <!-- for radios inputs -->
        <tr>
          <td><label for="feature">Featured: </label></td>
          <td>
            <?php radioDefaultInput($food['featured'], 'feature'); ?>
          </td>
        </tr>

        <tr>
          <td><label for="active">Active: </label></td>
          <td>
            <?php radioDefaultInput($food['active'], 'active'); ?>
          </td>
        </tr>

        <tr>
          <td>
            <input type="hidden" name="id" value="<?php echo $food['id']; ?>" />
            <input type="submit" value="submit" name="submit" class="btn-secondary" />
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<?php include('inc/footer.php'); ?>
<?php
function radioDefaultInput($radioInput, $radioName) {
  if ($radioInput == 'Yes') {
    echo "<input type='radio' name='$radioName' value='Yes' checked /> Yes  ";
    echo "<input type='radio' name='$radioName' value='No' /> No";
  } else {
    echo "<input type='radio' name='$radioName' value='Yes'  /> Yes  ";
    echo "<input type='radio' name='$radioName' value='No' checked /> No";
  }
}

if (isset($_POST['submit'])) {
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $categoryId = getCategoryID($category, $conn);
  $feature = mysqli_real_escape_string($conn, $_POST['feature']);
  $active = mysqli_real_escape_string($conn, $_POST['active']);
  $imgName = $food['image_name'];
  $newImg = editImage($imgName);

  //CREATE A QUERY THAT WILL UPDATE THE DATA BASE
  $query2 = "UPDATE tbl_food SET
              title = '$title',
              price = '$price',
              category_id = '$categoryId',
              description = '$description',
              image_name = '$newImg',
              featured = '$feature',
              active = '$active'
            WHERE 
              id = $id";

  if (mysqli_query($conn, $query2) or die(mysqli_error($conn))) {
    $_SESSION['edit-food'] = "<div class=\"success\">SUCCESSFULY UPDATED FOOD</div>";
    header('location:' . ROOT_URL . 'admin/manage-food.php');
  }
}

function editImage($imgName) {
  if (isset($_FILES['image']['name'])) {

    $newImg = $_FILES['image']['name'];
    if ($newImg != '') {
      deleteCurrentImg($imgName);
      return uploadNewImg($newImg);
    } else {
      return $imgName;
    }
  }
}

function deleteCurrentImg($imgName) {
  $isImg = $imgName != 'Image is not currently available' && $imgName != '';
  if ($isImg) {
    $imgPath = '../images/food/' . $imgName;
    if (file_exists($imgPath)) {
      echo 'img-deleted';
      unlink($imgPath);
    }
  }
}

function uploadNewImg($newImg) {
  $ext = explode('.', $newImg);
  $ext = '.' . end($ext);
  $renameImg = 'Food_Category_' . rand(000, 999) . $ext;
  $sourcePath = $_FILES['image']['tmp_name'];
  $destinationPath = '../images/food/' . $renameImg;
  move_uploaded_file($sourcePath, $destinationPath);
  return $renameImg;
}

# display the categories in the database
function displayCategories($conn) {
  # create a query that will select all the name of 
  $query3 = "SELECT title FROM tbl_category";

  # execute the query
  $res = mysqli_query($conn, $query3) or die(mysqli_error($conn));
  # fetch the data from the result
  $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);

  #free the result
  mysqli_free_result($res);

  foreach ($categories as $category) {
    $categ = $category['title'];
    echo "<option value='$categ'>$categ</option>";
  }
}

#get the category ID
function getCategoryID($category, $conn) {
  #create a query that will get ourcategory id in our database
  $query4 = "SELECT id FROM tbl_category WHERE title = '$category'";

  #execute the query the and return the id of the categry
  $res = mysqli_query($conn, $query4) or die(mysqli_error($conn));

  #fetch the id from the result;
  $categoryId = mysqli_fetch_assoc($res);

  # free the result 
  mysqli_free_result($res);

  return $categoryId['id'];
}
?>