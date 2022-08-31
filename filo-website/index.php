<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>item-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Item.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here --> 

    <?php 
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }

        if(isset($_SESSION['contact']))
        {
            echo $_SESSION['contact'];
            unset($_SESSION['contact']);
        }
    
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <p class="text-center"> Welcome to FiLo Lost and Found! You can take a look at lost item and if you recognize your item you can claim it now!</p>
            <p class="text-center"> Please note that additional verification will be required and we will be contacting you after your claim to do so. </p>
            <br>
            <h2 class="text-center">Explore Categories</h2>


            <?php 
                //create SDQL query to display categories from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                //execute the query
                $res = mysqli_query($conn, $sql);
                //count rows to check whether the category is available or not
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the values like id, title, image name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                                <a href="<?php echo SITEURL; ?>category-items.php?category_id=<?php echo $id; ?>">
                                    <div class="box-3 float-container">
                                        <?php 
                                            //check whether image is available or not

                                            if($image_name=="")
                                            {
                                                //display image
                                                echo "<div class='error'>image not available</div>";
                                            }
                                            else
                                            {
                                                //image avaible
                                                ?>
                                                <img src="<?php echo SITEURL;  ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                                <?php
                                            }
                                        
                                        ?>
                                       

                                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                    </div>
                                </a>  
                        
                        
                        
                        
                        <?php
                    }
                }
                else
                {
                    //category not available
                    echo "<div class='error'>Category not added</div>";
                }

            ?>
          

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->





    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Featured Items</h2>

            <?php

            //getting food from database that are actoive and featured
            //sql query
            $sql2 = "SELECT * FROM tbl_item WHERE active='Yes' AND featured='Yes'LIMIT 6";

            //execute the query
            $res2 = mysqli_query($conn, $sql2);

            //count the rows
            $count2 = mysqli_num_rows($res2);

            //check whether food available  or not
            if($count2>0)
            {
                //food available
                while($row=mysqli_fetch_assoc($res2))
                {
                    //get all the values
                    $id = $row['id'];
                    $title = $row['title'];
                    $date_found = $row['date_found'];
                    $image_name = $row['image_name'];
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
                        <a href="<?php echo SITEURL; ?>item-view.php?item_id=<?php echo $id; ?>"><?php echo $title; ?></a>
                            <p class="food-price"><?php echo $date_found; ?></p>
                           

                            <a href="<?php echo SITEURL; ?>item-view.php?item_id=<?php echo $id; ?>" class="btn btn-primary">More Info</a>
                        </div>
                     </div>

                    <?php
                }
            }
            else
            {
                //food not available
                echo "<div class='error'>Item not available</div>";
            }


            ?>


            <div class="clearfix"></div>
    

        </div>

        <p class="text-center">
            <a href="items.php">See All Items</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->


<?php include('partials-front/footer.php'); ?>