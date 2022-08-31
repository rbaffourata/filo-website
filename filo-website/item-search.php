<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php 

                //get the search keyword prevent sql injection on search bar
                $search = mysqli_real_escape_string($conn, $_POST['search']);

            
            ?>
            
            <h2>Items on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Items</h2>

            <?php 

                //sql query to get food based on search keyword
                //$search = burger'
                //"SELECT * tbl_item WHERE title LIKE '%%' or description LIKE '%%' ";
                $sql = "SELECT * FROM tbl_item WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                //execute the query
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                //check whether food available or not
                if($count>0)
                {
                    //food available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get the details
                        $id = $row['id'];
                        $title = $row['title'];
                        $date_found = $row['date_found'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php 
                                        //check whether image name is available or not
                                        if($image_name=="")
                                        {
                                            //image not available
                                            echo "<div class='error'>Image not available</div>";
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
                                <a href="<?php echo SITEURL; ?>item-view.php?item_id=<?php echo $id; ?>"><?php echo $title; ?></a>
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
                    echo "<div class='error'>Item not found</div>"; 
                }

            
            ?>

            

           

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>