<?php include('inc/header.php'); ?>
<?php

$query = "SELECT * FROM tbl_order ORDER BY id DESC";
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
$rowCount = mysqli_num_rows($res);
$orders = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res);
// print_r($orders);

?>
<div class="main-content">
  <div class="wrapper">
    <h1>Manage Order</h1>

    <?php
    if (isset($_SESSION['order-update'])) {
      echo $_SESSION['order-update'];
      unset($_SESSION['order-update']);
    }
    ?>
    <table class="tbl-full">
      <tr>
        <th>S.N.</th>
        <th>Full Name</th>
        <th>Ordered Food</th>
        <th>Food Price</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Order Date</th>
        <th>Status</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Address</th>
        <th>Action</th>
      </tr>

      <?php
      $sn = 0;
      if ($rowCount > 0) {
        foreach ($orders as $order) : $sn++; ?>
          <tr>
            <td><?php echo $sn; ?></td>
            <td><?php echo $order['customer_name']; ?></td>
            <td><?php echo $order['food']; ?></td>
            <td><?php echo $order['price']; ?></td>
            <td><?php echo $order['qty']; ?></td>
            <td><?php echo $order['total']; ?></td>
            <td><?php echo $order['order_date']; ?></td>
            <td>
              <?php

              switch ($order['status']) {
                case 'On Delivery':
                  echo '<label style="color: orange;">' . $order['status'] .  '</label>';
                  break;

                case 'Delivered':
                  echo '<label style="color: #2ed573;">' . $order['status'] .  '</label>';
                  break;

                case 'Cancelled':
                  echo '<label style="color: red;">' . $order['status'] .  '</label>';
                  break;

                default:
                  echo '<label>' . $order['status'] .  '</label>';
              }

              ?>
            </td>
            <td><?php echo $order['customer_email']; ?></td>
            <td><?php echo $order['customer_contact']; ?></td>
            <td><?php echo $order['customer_address']; ?></td>
            <td>
              <a href="<?php echo ROOT_URL; ?>admin/update-order.php?id=<?php echo $order['id']; ?>" class="btn-secondary">Update Order</a>
            </td>
          </tr>
      <?php endforeach;
      } else {
        echo '<tr><td colospan="12">NO ORDER YET</td></tr>';
      }
      ?>
    </table>
  </div>
</div>

<?php include('inc/footer.php'); ?>