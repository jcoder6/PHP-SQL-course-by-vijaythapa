<?php 
  include ('../config/constants.php');
  $id = $_GET['id'];
  $imgName = $_GET['img-name'];

  $isNoImg = $imgName == 'Image is not currently available' && $imgName != '';
  echo $isNoImg;


  // create a query to delete the food in our database
  $query = "DELETE FROM tbl_food WHERE id = $id";

  //now execute the query so and redirecto to manage food if our query is successfuly execute if nat let give an error message
  if(mysqli_query($conn, $query) or die(mysqli_error($conn))){
    //create a function that will delete the image in our file folder if and only the has a image
    deleteFoodImg($isNoImg, $imgName);

    // redirect our page to manage food page
    $_SESSION['delete-food'] = "<div class='success'>FOOD DELETED SUCCESSFULY</div>";
    header('location:' .ROOT_URL. 'admin/manage-food.php');
  } else {
    $_SESSION['delete-food'] = "<div class=\"error\">FAILED TO DELETE FOOD</div>";
    header('location:' .ROOT_URL. 'admin/manage-food.php');
  }

  function deleteFoodImg($isNoImg, $imgName){

    if(!$isNoImg) {
      // let specify the image path.
      $imgPath = '../images/food/' . $imgName;

      //check if our image path is existing
      if(file_exists($imgPath)){
        unlink($imgPath);
        // echo 'image exist';
      } else {
        echo 'image not found';
      }
    } else {
      echo 'no img found';
    }
  }
