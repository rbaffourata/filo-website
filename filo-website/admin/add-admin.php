<?php include('partials/menu.php');  ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
            if(isset($_SESSION['add'])) //Checking whether the session is set or not
            {
                echo $_Session['add']; //Displaying session message if set
                unset($_SESSION['add']); //Removing session message
            }

        ?> 
        
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                      <input type="text" name="full_name" placeholder="Enter your name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                    <input type="text" name="username" placeholder="Username"></td>
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                    <input type="password" name="password" placeholder="Password"></td>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>


            </table>





        </form>
    </div>

</div>







<?php include('partials/footer.php'); ?>


<?php 
    //Process value from form and save it in database
    //Check whether the button is clicked or not

    if(isset($_POST['submit']))
    {
        //Button Clicked
        //echo "Button Clicked";

        //1. Get the data from form
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $ppassword = md5($_POST['password']); //Password ecnryption with MD5
        $password = mysqli_real_escape_string($conn, $ppassword);

        //2. sql query to save the data into database
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        
        //3. Execute query and save data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error()); 


        //4. Check whether the (query is executed) data is insterted or not
        if($res==TRUE)
        {
            //Data inserted
            //echo "Data Inserted";
            //create Session Variable to Display Message
            $_SESSION['add'] = "Admin Added Successfully";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Failed to insert data
            //echo "Failed to insert data";
            $_SESSION['add'] = "Failed to Add Admin";
            //Redirect Page to Add Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }

    }
    ?> 