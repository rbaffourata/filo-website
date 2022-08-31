<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>


        <?php 

            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
      
        ?>

        <br><br>

        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class= "tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td> 
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image";>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Add Category Form Endss -->

        <?php 

            //check whether the submit button is clicked or not
            if(isset($_POST['submit']))
            {

                //1. get the value from category form
                $title = mysqli_real_escape_string($conn, $_POST['title']);


                //for radio input type, we need to check whether the button is selected or not
                if(isset($_POST['featured']))
                {
                    //get the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //set the default value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }
    
                //print_r($_FILES);

                if(isset($_FILES['image']['name']))
                {
                    //upload image
                    //to upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //auto rename our image
                    //get the extension of our image e.g. "football.jpg"
                    $ext = end(explode('.', $image_name));

                    //rename the image
                    $image_name = "Items-Category_".rand(000, 999).'.'.$ext; //e.g. Items_Category_834.jpg

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path=$_SERVER['DOCUMENT_ROOT']."/filo-website/images/category/".$image_name;

                    //upload the images

                    echo $destination_path;
                    echo $source_path;

                    $upload =  move_uploaded_file($source_path, $destination_path);
                  
                    
                    //check whether the image is uploaded or not
                    //and if the image is not uploaded then we will stop the process and redirect with error message
                     if($upload==false)
                   {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image </div>";

                        header('location:'.SITEURL.'admin/manage-category.php');

                        die();
                    }

                }
                else
                {
                    //don't upload image and set image_name value as blank
                    $image_name="";
                }
    

                //2/ create sql query to insert category into database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    featured='$featured',
                    active='$active',
                    image_name='$image_name'
                ";

                //3. execiute query and save in database
                $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                //4. check whether the query is exceuted or not and data added or not
                if($res==true)
                {
                    //query executed and category added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                } 
            }
        
        
        ?>

    </div>
</div>



<?php include('partials/footer.php'); ?>