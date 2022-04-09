<?php include('partials-front/header.php'); ?>
<!-- fOOD sEARCH Section Starts Here -->
<?php
// get the search key word
$search = $_POST['search'];
?>
<section class="food-search text-center">
    <div class="container">

        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php
//sql query base on search keyword;
$query = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

//execute a query so that we get the food with the keyword search;
$res = mysqli_query($conn, $query) or die(mysqli_error($conn));
$rowCount = mysqli_num_rows($res);
$foods = mysqli_fetch_all($res, MYSQLI_ASSOC);
mysqli_free_result($res);

if ($rowCount > 0) {
    // food available
    foreach ($foods as $food) : ?>
        <div class="food-menu-box">
            <div class="food-menu-img">
                <img src="<?php echo ROOT_URL; ?>images/food/<?php echo $food['image_name']; ?>" alt="<?php echo $food['title']; ?>" class="img-responsive img-curve">
            </div>

            <div class="food-menu-desc">
                <h4><?php echo $food['title']; ?></h4>
                <p class="food-price">₱<?php echo $food['price']; ?></p>
                <p class="food-detail">
                    <?php echo $food['description']; ?>
                </p>
                <br>

                <a href="<?php echo ROOT_URL; ?>order.php?food_id=<?php echo $food['id']; ?>" class="btn btn-primary">Order Now</a>
            </div>
        </div>
<?php endforeach;
} else {
    echo '<div class="error">food not found</div>';
}
?>

<div class="clearfix"></div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>