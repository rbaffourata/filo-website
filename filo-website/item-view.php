<?php include('partials-front/menu.php'); ?>

<?php
if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
?>

<section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>item-view.php" method="POST">
                <input type="search" name="search" placeholder="Search for Items..." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>

    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Item View</h2>

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

                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
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
            <div class="food-menu-box">
                <div class="food-menu-img">
                <?php 
                    //check whether image available or not
                    if($image_name=="")
                    {
                        //image not available
                        echo "<div class='error'>image not available</div>";
                    }
                    else
                    {
                        //image available
                        ?>
                            <img src="<?php echo SITEURL; ?>images/items/<?php echo $image_name; ?>" alt="Chicke Hawain Burger" class="img-responsive img-curve">
                        <?php 
                    }
                    
                    ?>
                </div>

                <div class="food-menu-desc">
                                    <h4>
                                        <a href="<?php echo SITEURL; ?>item-view.php?item_id=<?php echo $id; ?>"><?php echo $title; ?></a>
                                        
                                
                                </h4>
                                    <p class="food-price">Date Found: <?php echo $date_found; ?></p>
                                    <p class="food-detail">
                                        <?php echo $description; ?>
                                    </p>
                                    <br>

                                    
                                  

                                
                   
                                <a href="<?php echo SITEURL; ?>claim.php?item_id=<?php echo $id; ?>" class="btn btn-primary">Claim Now</a>

                </div>
                </div>
                </section>


                <div class="clearfix"></div>


<?php include('partials-front/footer.php'); ?>