<?php 

    //Include constants.php for SITEURL
    include('config/constants.php');
    //1. destroy the session
    session_destroy(); //UNSET $_SESSION
    
    //2. redirect to log in page
    header('location:'.SITEURL.'login.php');



?>