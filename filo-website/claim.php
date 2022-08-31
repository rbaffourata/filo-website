<?php include('partials-front/menu.php'); ?>

<?php 
        //heck whether food id is set or not
        if(isset($_GET['item_id']))
        {
            //get the food id details of selected item
            $item_id = $_GET['item_id'];
            //echo "hello";
            //get the details of selected food
            $sql = "SELECT * FROM tbl_item WHERE id=$item_id";

            //execute the query
            $res = mysqli_query($conn, $sql);
            //coiunt the rows
            $count = mysqli_num_rows($res);
            //check whether data is available or not
            if($count==1)
            {
                //echo "hi";
                //we have data
                //get data from dadatabse
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $date_found = $row['date_found'];
                $image_name = $row['image_name'];
                
            }
        
            else
            {
                //item not available
                //redirect to home page
                header('location:'.SITEURL);
            }
        }
        else
        {
            //redierect to home page
            header('location:'.SITEURL);
        } 


?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your claim.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Item</legend>

                    <div class="food-menu-img">
                        <?php

                            //check whether the image is available or not
                            if($image_name=="")
                            {
                                //image not available
                                echo "<div class='error'>Image not available</div>";
                                
                            }
                            else
                            {
                                //image is available
                                ?>
                                    <img src="<?php echo SITEURL;?>images/items/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }

                        ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="item" value="<?php echo $title; ?>">

                        <p class="food-price">Date Found: <?php echo $date_found; ?></p>
                        <input type="hidden" name="date_found" value="<?php echo $date_found; ?>">

                        
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Full Name" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="07xxxxxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="hi@email.com" class="input-responsive" required>

                    <div class="order-label">Request Reason and Address</div>
                    <textarea name="address" rows="10" placeholder="More item details
                    
                    
                    
Street, City, Postcode, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Claim" class="btn btn-primary">
                </fieldset>

            </form>

            <?php 

                //check whether submit button is clicked or not 
                if(isset($_POST['submit']))
                {
                    //get all the details from the form

                    $item = $_POST['item'];
                    $date_found = $_POST['date_found'];
                    

                    $claim_date = date("Y-m-d h:i:s");

                    $status = "claimed"; 

                    $customer_name = $_POST['full-name'];

                    $customer_contact = $_POST['contact'];

                    $customer_email = $_POST['email'];

                    $customer_address = $_POST['address'];

                    //save order in databse
                    //creat sql to save the data
                    $sql2 = "INSERT INTO tbl_claim SET
                        item = '$item',
                        date_found = '$date_found',
                        
                        claim_date = '$claim_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    //echo $sql2; die();

                    //execute qeury
                    $res2 = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

                    //check whether query executed success or not
                    if($res2==true)
                    {
                        //query execute and order saved
                        $_SESSION['order'] = "<div class='success text-center'>Item Claimed Successfully</div>";
                        header('location:'.SITEURL);
                        //echo "hi";
                    }
                    else
                    {
                        //failed to save order
                        $_SESSION['order'] = "<div class='error text-center'>Failed to claim item</div>";
                        header('location:'.SITEURL);
                        //echo "helo";
                    }
                


                }
            
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>