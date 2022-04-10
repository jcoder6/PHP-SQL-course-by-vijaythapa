<?php include('inc/header.php'); ?>
<?php

$id = $_GET['id'];

$query = "SELECT * FROM tbl_order WHERE id = $id";
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
$order = mysqli_fetch_assoc($res);
mysqli_free_result($res);
// print_r($order);

?>
<div class="main-content">
  <div class="wrapper">
    <h1>Update Order</h1>
    <br><br>
    <form action="" method="post">
      <table class="tbl-30">
        <tr>
          <td>Food Name: </td>
          <td><?php echo $order['food']; ?></td>
        </tr>

        <tr>
          <td>Quantity: </td>
          <td><input type="number" name="quantity" value="<?php echo $order['qty']; ?>"></td>
        </tr>

        <tr>
          <td>Status: </td>
          <td>
            <select name="status">
              <option <?php if ($order['status'] == 'Ordered') {
                        echo 'selected';
                      } ?> value="Ordered">Ordered</option>
              <option <?php if ($order['status'] == 'On Delivery') {
                        echo 'selected';
                      }
                      ?> value="On Delivery">On Delivery</option>
              <option <?php if ($order['status'] == 'Delivered') {
                        echo 'selected';
                      } ?> value="Delivered">Delivered</option>
              <option <?php if ($order['status'] == 'Cancelled') {
                        echo 'selected';
                      } ?> value="Cancelled">Cancelled</option>
            </select>
          </td>
        </tr>

        <tr>
          <td>Customer Name: </td>
          <td>
            <input type="text" name="customer_name" value="<?php echo $order['customer_name']; ?>" />
          </td>
        </tr>

        <tr>
          <td>Customer Contact: </td>
          <td>
            <input type="text" name="customer_contact" value="<?php echo $order['customer_contact']; ?>" />
          </td>
        </tr>

        <tr>
          <td>Customer Email: </td>
          <td>
            <input type="text" name="customer_email" value="<?php echo $order['customer_email']; ?>" />
          </td>
        </tr>

        <tr>
          <td>Customer Address:</td>
          <td>
            <textarea name="customer_address" cols="30" rows="5"><?php echo $order['customer_address']; ?></textarea>
          </td>
        </tr>

        <tr>
          <td><input type="hidden" name="price" value="<?php echo $order['price']; ?>"></td>
          <td><input type="hidden" name="id" value="<?php echo $order['id']; ?>"></td>
          <td><input type="submit" name="submit" value="Update Order" class="btn-secondary"></td>
        </tr>
      </table>
    </form>

  </div>
</div>
<?php include('inc/footer.php'); ?>

<?php

if (isset($_POST['submit'])) {
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $qty = mysqli_real_escape_string($conn, $_POST['quantity']);
  $total = $price * $qty;
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $name = mysqli_real_escape_string($conn, $_POST['customer_name']);
  $contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
  $email = mysqli_real_escape_string($conn, $_POST['customer_email']);
  $address = mysqli_real_escape_string($conn, $_POST['customer_address']);

  $query2 = "UPDATE tbl_order SET 
          qty = $qty,
          status = '$status',
          total = $total,
          customer_name = '$name',
          customer_contact = '$contact',
          customer_email = '$email',
          customer_address = '$address'
        WHERE
          id = $id";
  if (mysqli_query($conn, $query2) or die(mysqli_error($conn))) {
    $_SESSION['order-update'] = '<div class="success">ORDER UPDATE SUCCESSFULY</div>';
    header('location:' . ROOT_URL . 'admin/manage-order.php');
  } else {
    $_SESSION['order-update'] = '<div class="error">FAILED TO UPDATE ORDER</div>';
    header('location:' . ROOT_URL . 'admin/manage-order.php');
  }
}

?>