<?php include('partials-front/header.php'); ?>
<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo ROOT_URL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->
<?php
if (isset($_SESSION['order'])) {
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}
?>
<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <!-- FUNCTION THAT WILL DISPLAY ALL CATEGORIES RETURN FROM THE DATABASE -->
        <?php displayCategories($conn); ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <!-- FUNCTION THAT WILL DISPLAY ALL CATEGORIES RETURN FROM THE DATABASE -->
        <?php displayFeaturedFoods($conn); ?>

        <div class="clearfix"></div>
    </div>

    <p class="text-center">
        <a href="<?php echo ROOT_URL; ?>foods.php">See All Foods</a>
    </p>
</section>
<!-- fOOD Menu Section Ends Here -->
<?php include('partials-front/footer.php'); ?>


<?php
function displayCategories($conn) {
    // create sql query to display the categories from data base
    $query = "SELECT * FROM tbl_category WHERE active = 'Yes' AND featured = 'Yes' LIMIT 3";

    //execute the qeury to so that we can get all the data
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    //Fecth all the data that result of the query return;
    $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);

    //free the result form the query
    mysqli_free_result($res);

    // print_r($categories.);
    foreach ($categories as $category) : ?>
        <a href="<?php echo ROOT_URL; ?>category-foods.php?id=<?php echo $category['id']; ?>&&title=<?php echo $category['title']; ?>">
            <div class="box-3 float-container">
                <?php
                if ($category['image_name'] == 'Image is not currently available') {
                    echo '<div class="error">IMAGE IN NOT CURRENTLY AVAILABLE</div>';
                } else {
                ?>
                    <img src="<?php echo ROOT_URL; ?>images/category/<?php echo $category['image_name']; ?>" alt="<?php echo $category['image_name']; ?>" class="img-responsive img-curve">
                <?php
                }
                ?>
                <h3 class="float-text text-white"><?php echo $category['title']; ?></h3>
            </div>
        </a>
        <?php endforeach;
}

function displayFeaturedFoods($conn) {
    //repeat what you do in categories but in this case use tabel_food in database;
    $query = "SELECT * FROM tbl_food WHERE active = 'Yes' AND featured = 'Yes' LIMIT 6";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($res); //count the rows;
    $foods = mysqli_fetch_all($res, MYSQLI_ASSOC);
    mysqli_free_result($res);

    if ($rows > 0) {
        // echo 'display foodS';
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
        echo 'No foods';
    }
}
?>