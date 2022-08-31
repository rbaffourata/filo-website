<?php include('partials/menu.php'); ?>




<div class="main-content">
    <div class="wrapper"> 
        <h1>Manage Items</h1>


<br /><br />


<!-- Button to add Admin -->
<a href="<?php echo SITEURL; ?>admin/add-items.php" class="btn-primary">Add Lost Item</a>

<br /><br /><br />

<?php 
    if(isset($_SESSION['add']))
    {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    if(isset($_SESSION['delete']))
    {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }

    if(isset($_SESSION['upload']))
    {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
    }

    if(isset($_SESSION['unauthorize']))
    {
        echo $_SESSION['unauthorize'];
        unset($_SESSION['unauthorize']);
    }

?> 


<table class="tbl-full">
    <tr>
        <th>S.N.</th>
        <th>Title</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>

    <?php 

        
        //crerate sql query to get all the items
        $sql = "SELECT * FROM tbl_item";

        //execute query
        $res = mysqli_query($conn, $sql);

        //count rows to check whether we have items or not
        $count = mysqli_num_rows($res);

        //create serial number varialble and set default value as 1
        $sn=1;

        if($count>0)
        {
            //we have items in database
            // get the food from database and display
            while($row=mysqli_fetch_assoc($res))
            {
                //get the value from individual colums
                $id = $row['id'];
                $title = $row['title'];
                $image_name = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
                
            ?>
                
                <tr>
                    <td><?php echo $sn++; ?>.</td>
                    <td><?php echo $title; ?></td>
                    <td>
                        <?php 
                            //checke whether we have image or not
                            if($image_name=="")
                            {
                                //we do not have image display error message
                                echo "<div class='error'>Image not added</div>";
                            }
                            else
                            {
                                //we have to display image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/items/<?php echo $image_name; ?>" width="100px">
                                <?php

                            }
                        ?>
            
                    <td><?php echo $featured; ?></td>
                    <td><?php echo $active; ?></td>
                    <td>
                            <a href="<?php echo SITEURL; ?>admin/update-items.php?id=<?php echo $id; ?>" class="btn-secondary">Update Item</a>   
                            <a href="<?php echo SITEURL; ?>admin/delete-items.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Item</a>                   
                    </td>
                </tr>
                
                
                
                <?php 
            }
        } 
        else
        {
            //item not added in database
            echo "<tr> <td colspan='6' class='error'> Food not added yet </td> </tr>";
        }
    
    ?>

  

   
</table>

</div> 

</div>









<?php include('partials/footer.php'); ?>