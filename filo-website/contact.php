<?php include('partials-front/menu.php'); ?>



    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Contact Us</h2>

            <form action="" method="POST" class="order">       
                    </div>

                
                
                <fieldset>
                    <legend>Enquiry Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full_name" placeholder="Your Name" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact_number" placeholder="07xxxxxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="contact_email" placeholder="hi@email.com" class="input-responsive" required>

                    <div class="order-label">Enquiry</div>
                    <textarea name="enquiry" rows="10" placeholder="Your Enquiry" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    
                </fieldset>

                    <?php 
                        
                        if(isset($_POST['submit']))
                        {
                            //get all the details from the form
        
                            $yourName = $_POST['full_name'];
                            $yourPhone = $_POST['contact_number'];
                            $yourEmail = $_POST['contact_email'];
                            $enquiry = $_POST['enquiry'];
        
                            //save order in databse
                            //creat sql to save the data
                            $sql = "INSERT INTO tbl_contact SET
                                full_name = '$yourName',
                                contact_number = '$yourPhone',
                                contact_email = '$yourEmail',
                                enquiry = '$enquiry'
                            ";
        
                            //echo $sql2; die();
        
                            //execute qeury
                            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
                            //check whether query executed success or not
                            if($res==true)
                            {
                                //query execute and order saved
                                $_SESSION['contact'] = "<div class='success text-center'>Thank you! We will contact you soon.</div>";
                                header('location:'.SITEURL);
                                //echo "hi";
                            }
                            else
                            {
                                //failed to save order
                                $_SESSION['contact'] = "<div class='error text-center'>Failed to contact us.</div>";
                                header('location:'.SITEURL);
                                //echo "helo";
                            }
                        }
                       
                ?>

            </form>

          

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->




<?php include('partials-front/footer.php'); ?>