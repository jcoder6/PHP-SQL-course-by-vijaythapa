<?php include('inc/header.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Manage Food</h1>

    <?php
    if (isset($_SESSION['food-add'])) {
      echo $_SESSION['food-add'];
      unset($_SESSION['food-add']);
    }

    if (isset($_SESSION['img-upload'])) {
      echo $_SESSION['img-upload'];
      unset($_SESSION['img-upload']);
    }

    if (isset($_SESSION['delete-food'])) {
      echo $_SESSION['delete-food'];
      unset($_SESSION['delete-food']);
    }

    if (isset($_SESSION['edit-food'])) {
      echo $_SESSION['edit-food'];
      unset($_SESSION['edit-food']);
    }
    ?>

    <!-- Button to Admin -->
    <br />
    <br />
    <a href="add-food.php" class="btn-primary">Add Food</a>
    <br />
    <br />

    <table class="tbl-full">
      <tr>
        <th>S.N.</th>
        <th>Title</th>
        <th>Price</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Actions</th>
      </tr>

      <!-- fetch the food data from the database -->
      <?php $foods = getAllFood($conn);
      $sn = 0; ?>

      <!-- display each data to each webpage -->
      <?php foreach ($foods as $food) : $sn++ ?>
        <tr>
          <td><?php echo $sn; ?></td>
          <td><?php echo $food['title']; ?></td>
          <td>₱<?php echo $food['price']; ?></td>
          <td><img src="../images/food/<?php echo $food['image_name']; ?>" alt="<?php echo $food['image_name']; ?>" width="100px" /></td>
          <td><?php echo $food['featured']; ?></td>
          <td><?php echo $food['active']; ?></td>
          <td>
            <a href="<?php echo ROOT_URL; ?>admin/edit-food.php?id=<?php echo $food['id']; ?>" class="btn-secondary">Edit Food</a>
            <a href="<?php echo ROOT_URL; ?>admin/delete-food.php?id=<?php echo $food['id']; ?>&&img-name=<?php echo $food['image_name']; ?>" class="btn-danger">Delete Food</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>


<?php
function getAllFood($conn) {
  $query = "SELECT * FROM tbl_food";
  $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $foods = mysqli_fetch_all($res, MYSQLI_ASSOC);
  mysqli_free_result($res);
  mysqli_close($conn);

  return $foods;
}
?>
<?php include('inc/footer.php'); ?>