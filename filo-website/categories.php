<?php include('partials-front/menu.php'); ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Find Lost Items</h2>

            <?php 
                //displayall the categories that are active
                //sql query
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' ";

                //execute the query
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                //check whether categories available or not
                if($count>0)
                {
                    //categroy is available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //get all the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        
                             <a href="<?php echo SITEURL; ?>category-items.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php 
                                        if($image_name=="")
                                        {
                                            //image not avaialble
                                            echo "<div class='error'>Imagenot found</div>";
                                        }
                                        else
                                        {
                                            //image available
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
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
                    //category is not available
                    
                }
            ?>

    



            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->



    <?php include('partials-front/footer.php'); ?>