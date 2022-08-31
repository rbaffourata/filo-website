<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Claims</h1>
        <br><br>

        <?php 

            $from = "rbaffourata@gmail.com";
            $to = $customer_name;
            $subject = "You've just claimed and item!'";
            $message = "Thank you for claiming your item! We will contact you very soon.";
            $headers = "From:" . $from;

            $from = "rbaffourata@gmail.com";
            $to = $customer_name;
            $subject2 = "Your claim has been rejected!!'";
            $message2 = "Unfortunately your claim was not verified. We will contact you soon.";
            $headers = "From:" . $from;


            //check whether id is set or not
            if(isset($_GET['id']))
            {
                //get order details
                $id=$_GET['id'];

                //get all other details based on this id
                //sql query to get the dclaim details
                $sql = "SELECT * FROM tbl_claim WHERE id=$id";
                //execute the qeury
                $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                //count rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //detail available
                    $row=mysqli_fetch_assoc($res);

                    $item = $row['item'];
                    $date_found = $row['date_found'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                }
                else
                {
                    //detail not available
                    //redirect to manage claims
                    header('location:'.SITEURL.'admin/manage-claims.php');

                }
            }
            else
            {
                //redirect to manage order page
                header('location:'.SITEURL.'admin/manage-claims.php');
            }
        
        ?>
        
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Item Name</td>
                    <td><b> <?php echo $item; ?> </b></td>
                </tr>

                <tr>
                    <td>Date Found:</td>
                    <td>
                        <b><?php echo $date_found; ?></b>
                    </td>
                </tr>


                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status" >
                            <option <?php if($status=="Claimed"){echo "selected";} ?> value="Claimed">Claimed</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?>value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?>value="Delivered">Delivered</option>
                            <option <?php if($status=="Unaccepted"){echo "selected";} ?>value="Unaccepted">Unaccepted</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email:</td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address:</td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id;  ?>">
                            <input type="hidden" name="date_found" value="<?php echo $date_found;  ?>">

                            <input type="submit" name="submit" value="Update Claim" class="btn-secondary">
                    </td>
                </tr>
                

            </table>


        </form>

        <?php 
            //check whether update button is clicked or not
            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //get all the values from form
                $id = $_POST['id'];
                $date_found = $_POST['date_found'];

                $status = $_POST['status'];

                $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
                $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
                $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
                $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);
                

                //update the values
                $sql2 = "UPDATE tbl_claim SET
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id=$id
                ";

                //execute query
                $res2 = mysqli_query($conn, $sql2);

                //check whether updated or not

                //redirect to manage claims with message
                if($res2==true)
                {
                    //updated
                    $_SESSION['update'] = "<div class='success'>Claim Updated Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-claims.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update'] = "<div class='error'>Failed to update claim</div>";
                    header('location:'.SITEURL.'admin/manage-claims.php');
                }
    
                    if($status=="Claimed" AND mail($to,$subject,$message, $headers)) {
                        echo "The email message was sent.";
                    } else {
                        echo "The email message was not sent.";
                    }
                
        
                    
                    if($status="Unaccepted" AND mail($to,$subject2,$message2, $headers)) {
                        echo "The email message was sent.";
                    } else {
                        echo "The email message was not sent.";
                    }
                }
       
            
        
        ?>
        




    </div>


</div>









<?php include('partials/footer.php'); ?>