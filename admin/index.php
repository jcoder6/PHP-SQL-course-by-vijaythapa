<?php include('inc/header.php') ?>
<!-- Main Section Starts -->
<div class="main-content">
  <div class="wrapper">
    <h1>Dashboard</h1>

    <?php
    if (isset($_SESSION['login'])) {
      echo $_SESSION['login'];
      unset($_SESSION['login']);
    }
    ?>

    <div class="col-4 text-center">
      <?php
      $query = "SELECT * FROM tbl_category";
      $row = 0;
      if (mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        $row = mysqli_num_rows(mysqli_query($conn, $query));
      }
      ?>
      <h1><?php echo $row; ?></h1>
      <br>
      Categories
    </div>

    <div class="col-4 text-center">
      <?php
      $query2 = "SELECT * FROM tbl_food";
      $row2 = 0;
      if (mysqli_query($conn, $query2) or die(mysqli_error($conn))) {
        $row2 = mysqli_num_rows(mysqli_query($conn, $query2));
      }
      ?>
      <h1><?php echo $row2; ?></h1>
      <br>
      Foods
    </div>

    <div class="col-4 text-center">
      <?php
      $query3 = "SELECT * FROM tbl_order";
      $row3 = 0;
      if (mysqli_query($conn, $query3) or die(mysqli_error($conn))) {
        $row3 = mysqli_num_rows(mysqli_query($conn, $query3));
      }
      ?>
      <h1><?php echo $row3; ?></h1>
      <br>
      Orders
    </div>

    <div class="col-4 text-center">
      <?php

      $query4 = "SELECT SUM(total) as total FROM tbl_order WHERE status = 'Delivered'";
      $res = mysqli_query($conn, $query4) or die(mysqli_error($conn));
      $total = mysqli_fetch_assoc($res);

      ?>
      <h1>₱<?php echo $total['total']; ?></h1>
      <br>
      Total Revenue
    </div>

    <div class="clearfix"></div>
  </div>
</div>
<!-- Main Section Ends -->
<?php include('inc/footer.php') ?>