<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper"> 
        <h1>Manage Claims</h1>

<br /><br />


<!-- Button to add Admin -->

<br /><br /><br />

<?php 
    if(isset($_SESSION['update']))
    {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }


?>


<table class="tbl-full">
    <tr>
        <th>S.N.</th>
        <th>Item </th>
        <th>Date Found</th>
        <th>Quantity</th>
        <th>Claim Date</th>
        <th>Status</th>
        <th>Customer Name</th>
        <th>Customer Contact</th>
        <th>Customer Email</th>
        <th>Customer Address</th>
        <th>Actions</th>
    </tr>

    <?php 
            //get all the orders from dtaabase
            $sql = "SELECT * FROM tbl_claim ORDER BY id DESC";
            //execute query
            $res = mysqli_query($conn, $sql);
            //count the rows
            $count = mysqli_num_rows($res);

            $sn = 1; //create srial number amnd set initial value as 1

            if($count>0)
            {
                //order available
                while($row=mysqli_fetch_assoc($res))
                {
                    //get all the order details
                    $id = $row['id'];
                    $item = $row['item'];
                    $date_found = $row['date_found'];
                    $quantity = $row['quantity'];
                    $claim_date = $row['claim_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];

                    ?>

                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $item; ?></td>
                            <td><?php echo $date_found; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo $claim_date; ?></td>

                            <td>
                                <?php 
                                    //Claimed, On Delivery, Delivered, Unaccepted
                                    if($status=="Claimed")
                                    {
                                        echo "<label>$status</label>";
                                    }
                                    elseif($status=="On Delivery")
                                    {
                                        echo "<label style='color: orange;'>$status</label>";
                                    }
                                    elseif($status=="Delivered")
                                    {
                                        echo "<label style='color: green;'>$status</label>";
                                    }
                                    elseif($status=="Unaccepted")
                                    {
                                        echo "<label style='color: red;'>$status</label>";
                                    }

                                
                                ?>
                        </td>




                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $customer_contact; ?></td>
                            <td><?php echo $customer_email; ?></td>
                            <td><?php echo $customer_address; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-claims.php?id=<?php echo $id; ?>" class="btn-secondary">Update Claim</a>                    
                            </td>
                        </tr>

                    <?php

                }
            }
            else
            {
                //order not available
                echo "<tr><td colspan='11' class='error'>Claim not available</td></tr>";
            }
    
    
    ?>



</table>

</div> 

</div>









<?php include('partials/footer.php'); ?>