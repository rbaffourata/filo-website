<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>item-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Items..." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">All Items</h2>

            <?php 
                    //display foods that are actice
                    $sql = "SELECT * FROM tbl_item WHERE active='Yes'ORDER BY date_found DESC";

                    //execute the uery
                    $res = mysqli_query($conn, $sql);

                    //count rows
                    $count = mysqli_num_rows($res);

                    //check whether the items are avaiable or not
                    if($count>0)
                    {
                        
                        //item is available
                        while($row=mysqli_fetch_assoc($res))
                        {
                            
                           //get the values
                            $id = $row['id'];
                            $title = $row['title'];
                            $description = $row['description'];
                            $date_found = $row['date_found'];
                            $image_name = $row['image_name'];
                            ?>
                                <div class="food-menu-box">
                                    <div class="food-menu-img">

                                    <?php 
                                        //check whether image avaialble ir not
                                        if($image_name=="")
                                        {
                                            //image not availabe
                                            echo "<div class='error'>image not available</div>";
                                        }
                                        else
                                        {
                                            //image available
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/items/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                                
                                    ?>
                                        
                                </div>

                                 <div class="food-menu-desc">
                                    <h4>
                                        <a href="<?php echo SITEURL; ?>item-view.php?item_id=<?php echo $id; ?>"><?php echo $title; ?></a>
                                        
                                
                                </h4>
                                    <p class="food-price"><?php echo $date_found; ?></p>
                                   
                                    <br>

                                    <a href="<?php echo SITEURL; ?>item-view.php?item_id=<?php echo $id; ?>" class="btn btn-primary">More Info</a>
                                </div>
                                </div>

                            <?php
                        }
                    }
                    else
                    {
                        //food not available
                        echo "<div class='error'>item not found</div>";
                    }
                    
                
            
            ?>

</div>

            <div class="clearfix"></div>

            

    

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>