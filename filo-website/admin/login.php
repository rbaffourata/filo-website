<?php include('../config/constants.php'); ?>


<html>
    <head>
        <title>Login- Not Lost But Found System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
            
            ?>

            <br><br>


            <!-- Login form starts here -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter username"> <br><br>

                Password: <br>
                <input type="password" name="password" placeholder="Enter password"> <br><br>

                <input type="submit" name="submit" value="Log In" class="btn-primary">
                <br><br>

            </form>


            <!-- Login form starts here -->



            <p class="text-center">Created By - <a href="#">Ruth Baffour Ata</a></p>





        </div>
    </body>


</html>

<?php 
    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //Process for login
        //1. Get the data from login form
        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        //2. sql to check whether the username and password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password' ";

        //3. execute the query
        $res = mysqli_query($conn, $sql);

        //4.    Count rows to check whther the user exists or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User available and login succes
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            $_SESSION['user'] = $username;// to check whether user is logged in or logged out


            //redirect to dashboard or homepage
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //user not available and login fail
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
            //redirect to dashboard or homepage
            header('location:'.SITEURL.'admin/login.php');
        }
    }



?>