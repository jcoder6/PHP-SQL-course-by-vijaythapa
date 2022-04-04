<?php include('inc/header.php'); ?>

  <div class="main-content">
    <div class="wrapper">
    
    <h1>Add Food</h1>
    <br><br>
      <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-full">
          <tr>
            <td>Title</td>
            <td><input type="text" name="title" placeholder="Title" /></td>
          </tr>

          <tr>
            <td>Description: </td>
            <td><textarea name="description" placeholder="Description" id="" cols="30" rows="5"></textarea></td>
          </tr>
          
          <tr>
            <td>Price: </td>
            <td><input type="number" name="price"></td>
          </tr>

          <tr>
            <td>Insert Image</td>
            <td><input type="file" name="image" /></td>
          </tr>

          <tr>
            <td>Category</td>
            <td><select name="category">
              <option value="launch">Launch</option>
              <option value="breakfast">Break Fast</option>
              <option value="dinner">Dinner</option>
            </select></td>
          </tr>

          <tr>
            <td><label for="feature">Feature: </label></td>
            <td>
              <input type="radio" name="feature" value="Yes"> Yes 
              <input type="radio" name="feature" value="No" checked> No
            </td>  
          </tr>

          <tr>
            <td><label for="active">Active: </label></td>
            <td>
              <input type="radio" name="active" value="Yes"> Yes 
              <input type="radio" name="active" value="No" checked> No
            </td>  
          </tr>

          <tr>
            <td><input type="submit" name="submit" value="submit" class="btn-primary"/></td>
          </tr>
        </table>
      </form>

      <?php 
        if(isset($_POST['submit'])){
          #get the inputs data
          $title = mysqli_real_escape_string($conn, $_POST['title']);
          $desc = mysqli_real_escape_string($conn, $_POST['description']);
          $price = mysqli_real_escape_string($conn, $_POST['price']);
          $category = mysqli_real_escape_string($conn, $_POST['category']);
          $feature = mysqli_real_escape_string($conn, $_POST['feature']);
          $active = mysqli_real_escape_string($conn, $_POST['active']);
          $imgName = imgFunction($conn);

          // echo $title . $desc . $price . $category . $feature . $active . $imgName;

          #add the inputs data in our database
          addDataInDatabase($title, $desc, $price, $imgName, $category, $feature, $active, $conn);

         
        }

        #for image inputs
        #check if there has a image
        function imgFunction($conn) {
          if(isset($_FILES['image']['name'])){
            #get the image name
            $imgName = mysqli_real_escape_string($conn, $_FILES['image']['name']);

            // check wether there hava an image
            if($imgName != ""){
              #rename the image
              # 1. get the extension name of the image
              $ext = explode('.', $imgName);
              $ext = '.' . end($ext);
              
              # 2. generate the image name with random number
              $imgNewName = 'Food_Category_' . rand(000, 999) . $ext;

              #upload the image in to our file folder
              # 1. get the source path
              $sourcePath = $_FILES['image']['tmp_name'];

              # 2. get the desitnation path
              $destinationPath = '../images/food/' . $imgNewName;
              # 3. upload the image
              if(!move_uploaded_file($sourcePath, $destinationPath)){
                // $_SESSION['img-upload'] = "<div class='error'>SOMETHING WENT WRONG</div>";
                // header('location:' . ROOT_URL . 'admin/manage-food.php');
                echo "<div class='error'>SOMETHING WENT WRONG</div>";
                die();
              }
              return $imgNewName;
            }

            return "Image is not curretly available";
          }
        }

        function addDataInDatabase($title, $desc, $price, $imgName, $category, $feature, $active, $conn){
          # create a query to select a table in our database and update the database;
          $query = "INSERT INTO tbl_food(title, description, price, image_name, category_Id, featured, active)
                  VALUE('$title', '$desc', '$price', '$imgName', '$category', '$feature', '$active')";

          if(mysqli_query($conn, $query) or die(mysqli_error($conn))){
            echo "sucessssssssssss";
          }
        }
      ?>
    </div>
  </div>

<?php include('inc/footer.php'); ?>