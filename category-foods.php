<?php include('partials-front/header.php'); ?>
<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <h2>Foods on <a href="#" class="text-white">"<?php echo $_GET['title']; ?>"</a></h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h1 class="text-center">Food Menu</h1>

        <?php
        $id = $_GET['id'];
        $query = "SELECT * FROM tbl_food WHERE category_Id = $id";

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
            echo '<div class="error">No foods yet</div>';
        }
        ?>

        <div class="clearfix"></div>
    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>