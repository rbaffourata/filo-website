<?php  include('partials/menu.php');  ?>

 <div class="main-content">
 <div class="wrapper">

        <h1>Add Lost Item</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">

        <tr>
            <td>Title: </td>
            <td>
                <input type="text" name="title" placeholder="Title of Item">
            </td>
        </tr>

        <tr>
            <td>Description: </td>
            <td>
                <textarea name="description" cols="30" rows="10" placeholder="Description of lost item"></textarea>
            </td>
        </tr>

        <tr>
                <td>Date Found: </td>
                <td>
                    <input type="date" name="date_found" placeholder="date_found">
                </td>
        </tr>

        <tr>
            <td>Select Image: </td>
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
                                $id = $row['id'];
                                $title = $row['title'];

                                ?>

                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                <?php

                            }
                        }
                        else
                        {
                            //we do not have category
                            ?>

                            <option value="1">No Category Found</option>

                            <?php
                        }
                        //2.display dropdown
                    ?>

                </select>
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
            <td colspan="2">
                <input type="submit" name="submit" value="Add Item" class="btn-secondary">
            </td>
        </tr>



        </table>
    </form>

    <?php 
        //check whether the button is clicked or not
        if(isset($_POST['submit']))
        {
            //add the food in database
            //echo "Clicked";
            
            //1. Get the data from form
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $category = $_POST['category'];
            $date_found = $_POST['date_found'];

            //check whether radio button for featured and active are checkes or not
            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else
            {
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


            //2. upload image if selected
            //check whether select image is clicked or not and upload the image only if the image is selected
            if(isset($_FILES['image']['name']))
            {
                
                //get the details of the selected image
                $image_name = $_FILES['image']['name'];

                //check whether thr image is selected or not and upoload image only if selected
                if($image_name!="")
                {
                    //image is selected
                    //a. renamne the image
                    $ext = end(explode('.', $image_name));

                    //create new name for image
                    $image_name = "Item-Name-".rand(0000,9999).".".$ext;
                    

                    //b. upload the image
                    //get the src oath and destination path

                    $src = $_FILES['image']['tmp_name'];
                    
                    $dst = "../images/items/".$image_name;

                    //finaly upload the item image
                    $upload = move_uploaded_file($src, $dst);

                    //check whether image uploaded ot not
                    if($upload==false)
                    {
                        //failed to upload image
                        //redirect to items page with error message
                        $_SESSION['upload'] = "<div class='error'>failed to upload image</div";
                        header('location:'.SITEURL.'admin/add-items.php');
                        //stop the porcess
                        die();
                    }

                }
            }
            else
            {
                $image_name = "";
            }

            //3. insert into database

            //create a sql query to save or add items
            $sql2 = "INSERT INTO tbl_item SET
                title = '$title',
                description = '$description',
                date_found = '$date_found',
                image_name = '$image_name',
                category_id =  $category,
                featured = '$featured',
                active = '$active'
             ";

             //execture the query
             $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));


             if($res2==true)
             {
                //data inserted successfully
                $_SESSION['add'] = "<div class='success'>item added successfully</div>";
                header('location:'.SITEURL.'admin/manage-items.php' );
             }
             else
             {
                //failed to insert data
                $_SESSION['add'] = "<div class='error'>failed to add item</div>";
                header('location:'.SITEURL.'admin/manage-items.php' );
             }


            //4. redirect with message to manage food page
        }
    
    
    
    
    ?>




    </div>
 </div>


<?php  include('partials/footer.php');  ?>