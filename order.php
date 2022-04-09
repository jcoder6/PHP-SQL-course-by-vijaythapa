<?php include('partials-front/header.php'); ?>
<?php

if (isset($_GET['food_id'])) {
    $id = $_GET['food_id'];
    $query = "SELECT * FROM tbl_food WHERE id = $id";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $isNotNull = mysqli_num_rows($res) > 0;
    $food = mysqli_fetch_assoc($res);
    if ($isNotNull) {
        $foodImg = $food['image_name'];
        $title = $food['title'];
        $price = $food['price'];
    }
} else {
    header('loacation:' . ROOT_URL);
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <img src="<?php echo ROOT_URL; ?>images/food/<?php echo $foodImg; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->


<?php
if (isset($_POST['submit'])) {
    $food = mysqli_real_escape_string($conn, $_POST['food']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $qty = mysqli_real_escape_string($conn, $_POST['qty']);
    $total = $price * $qty;
    $orderDate = date('Y-m-d h:i:sa');
    $status = 'Ordered'; // ordered, on delivery, delivered and cancelled
    $customerName = mysqli_real_escape_string($conn, $_POST['full-name']);
    $customerContact = mysqli_real_escape_string($conn, $_POST['contact']);
    $customerEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $customerAddress = mysqli_real_escape_string($conn, $_POST['address']);

    //sava the order in the data base
    //Create a nsql to create a data
    $query2 = "INSERT INTO tbl_order(
            food, 
            price, 
            qty, 
            total, 
            order_date, 
            status, 
            customer_name, 
            customer_contact, 
            customer_email, 
            customer_address
        ) 
        VALUES (
            '$food',
             $price,
             $qty,
             $total,
             '$orderDate',
             '$status',
             '$customerName',
             '$customerContact',
             '$customerEmail',
             '$customerAddress'
        )";

    //execute the query;
    $res2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));
    if ($res2) {
        // query executed sucessfully
        $_SESSION['order'] = '<div class="success text-center">ORDER SUCCESSFULY</div>';
        header('location:' . ROOT_URL);
    } else {
        //failed to execute the query
        $_SESSION['order'] = '<div class="error text-center">FAILED TO PLACE ORDER</div>';
        header('location:' . ROOT_URL);
    }
}

?>

<?php include('partials-front/footer.php'); ?>