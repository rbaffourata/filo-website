<?php

    //Include constants.php file here
    include('../config/constants.php');


    //1. Get the ID of the admin to be deleted
    $id = $_GET['id'];

    //2. Create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";


    //Execute the query
    $res = mysqli_query($conn, $sql);


    //check whether the quesry executed successfully or not
    if($res==true)
    {
        //query executed successfully and admin deleted
        //echo "Admin Deleted";
        //Create session variable to display message
        $_SESSION['delete'] =  "<div class='success'>Admin Deleted Successfully</div>";
        //Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        // failed to delete admin
        //echo 'Failed to Delete Admin';

        $_SESSION['delete'] = "div class='error'>Failed to delete admin. Try Again later</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    
    //3. Redirect to manage admin page with message (success/error)

?>