<?php
  include ('../config/constants.php');

  //GET THE ID WE PASS FROM THE URL
  $id = $_GET['id'];

  //CREATE A SQL QUERY THAT WILL DELETE THE CATEGORY BASE ON THE WE GIVE INTO IT
  $query = "DELETE FROM tbl_category WHERE id = $id";
  //CREATE A QUERY THAT WILL GET OUR IMAGE NAME TO DATA
  // THIS QUERY IS TO DELETE OUR IMAGE FILE INTO FOLDER
  $query2 = "SELECT image_name FROM tbl_category WHERE id = $id";

  
  function deleteDataFromDataBase($conn, $query) {
    //EXECUTE THE QUERY TO FINALLY DELETE THE CATEGORY
    //ALSO CHECK THE QUERY IS SUCCESSFUL OR NOT SO THAT WE CAN SET THEIR SIGNIFICANT MESSAGE
    if(mysqli_query($conn, $query) or die(mysqli_error($conn))){
      $_SESSION['delete'] = "<div class='success'>CATEGORY DELETED SUCCESSFULY</div>";
      header('location:' .ROOT_URL. 'admin/manage-category.php');
    } else {
      $_SESSION['delete'] = "<div class='error'>FAILED TO DELETE CATEGORY</div>"; 
      header('location:' .ROOT_URL. 'admin/manage-category.php');
    }
  }

  function deleteImageFromFolder($conn, $query2) {
    //EXECUTE OUR SECOND QUERY TO GET THE IMAGE FILE NAME IN DATABASE
    $res = mysqli_query($conn, $query2);

    //FETCH THE RESULT OUR FROM THE RESULT TO GET THE IMAGE NAME;
    $imgName = mysqli_fetch_assoc($res);

    //FREE THE RESULT
    mysqli_free_result($res);

    //CHECK WETHER THE IMAGE IS EXISTING OR NOT

    $imgPath = "../images/category/" .$imgName['image_name'];

    if(file_exists($imgPath)){
      // echo "file exists";
      unlink($imgPath);
    } else {
      $_SESSION['delete'] = "<div class='error'>SOMETHING WENT WRONG</div>";
    }
  }

  deleteImageFromFolder($conn, $query2);
  deleteDataFromDataBase($conn, $query);
