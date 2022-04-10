<?php include('partials-front/header.php'); ?>


<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        // create sql query to display the categories from data base
        $query = "SELECT * FROM tbl_category";

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
        ?>



        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>