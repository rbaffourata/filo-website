<?php 
 //Authorization - acces control
 //check whether the user is logged or not

 if(!isset($_SESSION['loggedin'])) //if user session is not set
 {
    //user is not logged in
    //redirect to login page with message
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please log in to access Admin panel</div>";
    //redirect to login page
    header('location:'.SITEURL.'login.php');
 }



?> 