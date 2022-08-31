<?php include('partials/menu.php'); ?>

<?php 
    //check whetehr id is set or not
    if(isset($_GET['id']))
    {
        //get all the details
        $id = $_GET['id'];

        //sl query to get the selected folder
        $sql2 = "SELECT * FROM tbl_item WHERE id=$id";
        //execute the query
        $res2 = mysqli_query($conn, $sql2);

        //get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //get the individual value of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $category = $row2['category'];
        $date_found = $row2['date_found'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
        
    }
    else
    {
        //redirect to mamage food
        header('location:'.SITEURL.'admin/manage-items.php');
    }


?>

<div class="main-contnet">
    <div class="wrapper">
        <h1>Update Items</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value=<?php echo $title; ?> >
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>

                </td>
            </tr>

            <tr>
                <td>Date Found: </td>
                <td>
                    <input type="date" name="date_found" value=<?php echo $date_found; ?>>
                </td>
        </tr>

        <tr>
            <td>Current Image: </td>
            <td>
                <?php 
                    if($current_image == "")
                    {
                        //image not available
                        echo "<div class='error'>Image not available</div>";
                    }
                    else
                    {
                        //image available
                        ?>
                        <img src="<?php echo SITEURL; ?>images/items/<?php echo $current_image; ?>" width="150px">
                        <?php
                    }
                    
                
                ?>
            </td>
        </tr>

        <tr>
            <td>Select New Image: </td>
            <td>
                <input type="file" name="image" multiple>
            </td>
        </tr>

        <tr>
            <td>Category: </td>
            <td>
                <select name="category">

                <?php 
                        //create php code to display categories from database
                        //1. create sql query to get all active categories from database
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes' ";    

                        //execute query
                        $res = mysqli_query($conn, $sql);

                        //count rows to check whether we have category or not
                        $count = mysqli_num_rows($res);

                        //if count is greater than zero we have categories or else we dont
                        if($count>0)
                        {
                            //we have categories
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //get the detsails of categopry
                                $category_title = $row['title'];
                                $category_id = $row['id'];

                                //echo "<option value='$category_id'>$category_title</option>";
                                ?>
                                <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php  echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                            }
                        }
                        else
                        {
                           //category not available
                           echo "<option value='0'>Category not available</option>";
                        }
                    ?>

                    
                </select>
            </td>
            <tr>

        <tr>
            <td>Featured: </td>
            <td>
                <input <?php if($featured=="Yes") {echo "checked"; }?> type="radio" name="featured" value="Yes"> Yes
                <input <?php if($featured=="No") {echo "checked"; }?> type="radio" name="featured" value="No"> No
            </td>
        </tr>

        <tr>
            <td>Active: </td>
            <td>
            <input <?php if($active=="Yes") {echo "checked"; } ?> type="radio" name="active" value="Yes"> Yes
            <input <?php if($active=="No") {echo "checked"; } ?> type="radio" name="active" value="No"> No
            </td> 
        </tr>

        <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php  echo $current_image ?>">

                    <input type="submit" name="submit" value="Update Items" class="btn-secondary">
                </td>
            </tr>

                    </table>
        </form>

        <?php 
                if(isset($_POST['submit']))
                {
                    //echo "Button clicked";
                

                      //1. get all the details from the form
                      $id = $_POST['id'];
                      $title = mysqli_real_escape_string($conn, $_POST['title']);
                      $description = mysqli_real_escape_string($conn, $_POST['description']);
                      $date_found = $_POST['date_found'];
                      $current_image = $_POST['current_image'];
                      $category = $_POST['category'];
                      $featured = $_POST['featured'];
                      $active = $_POST['active'];

                      /* //debugging
                      echo $id . PHP_EOL; 
                      echo $title.'hello'; 
                      echo $description . 'hello2'; 
                      echo $date_found . 'hello3'; 
                      echo $current_image . 'hello4'; 
                      echo $category . 'hello5'; 
                      echo $featured . 'hello6'; 
                      echo $active . 'hello7'; 

                */
                    
                    //2. uploa the image if selected
                    if(isset($_FILES['image']['name']))
                    {
                        //upload button clicked
                        $image_name = $_FILES['image']['name'];

                        if($image_name!="")
                        {
                            //image is avaiable
                            $ext = end(explode('.', $image_name));

                            $image_name = "Item Name-".rand(0000,9999).'.'.$ext;

                            //get the source path and destination path
                            $src_path = $_FILES['image']['tmp_name'];
                            $dest_path = "../images/items/".$image_name;

                            //upload image
                            $upload = move_uploaded_file($src_path, $dest_path);
                            
                            //heck whether the image is uploaded or not
                            if($upload==false)
                            {
                                //failed to upload
                                $_SESSION['upload'] = "<div class='error'>failed to upload new image</div>";

                                header('location:'.SITEURL.'admin/manage-items.php');

                                die();
                            }
                            // remove current image if available
                            if($current_image!="")
                            {
                                //current image is available
                                //remove the image
                                $remove_path = "../images/items/".$current_image;

                                $remove = unlink($remove_path);

                                if($remove==false)
                                {
                                    //failed to remove current image
                                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image</div>";

                                    header('location:'.SITEURL.'admin/manage-items.php');

                                    die();
                                }
                            }
                        }
                        else
                        {
                            $image_name = $current_image; 
                        }
                    }    
                    else
                    {
                        $image_name = $current_image;
                    }

                
                    //4. update the items in database

                    $sql3 = "UPDATE tbl_item SET
                        `title` = '$title',
                        `description` = '$description',
                        `date_found` = '$date_found',
                        `image_name` = '$image_name',
                        `category_id` = $category,
                        `featured` = '$featured',
                        `active` = '$active'
                        WHERE id=$id
                     ";

                
                $res3 = mysqli_query($conn, $sql3) or die(mysqli_error($conn));

                if($res3==true)
                {
                    $_SESSION['update'] = "<div class='success'>Item Updated successfully</div>";
                    header('location:'.SITEURL.'admin/manage-items.php');
                }
                else
                {

                }
                    
                    //redirect to manage with session message
                    $_SESSION['update'] = "<div class='success'>item Updated successfully</div>";
                    header('location:'.SITEURL.'admin/manage-items.php');
                }
            
            
            
        
        
        
        ?>




    </div>

</div>
   











<?php include('partials/footer.php'); ?>