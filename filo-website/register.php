<?php include('partials-front/menu.php'); ?>

<?php
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Please enter a username.";
    } 
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"])))
    {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } 
    else
    {
        // Prepare a select statement
        $sql = "SELECT id FROM tbl_users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken.";
                } 
                else
                {
                    $username = trim($_POST["username"]);
                }
            }
             else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"])))
    {
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6)
    {
        $password_err = "Password must have atleast 6 characters.";
    } else
    {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"])))
    {
        $confirm_password_err = "Please confirm password.";     
    } else
    {
        $confirm_password = trim($_POST["confirm_password"]);

        if(empty($password_err) && ($password != $confirm_password))
        {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
    {
        
        // Prepare an insert statement
        $sql2 = "INSERT INTO tbl_users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($conn, $sql2))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Redirect to login page
                header('location:'.SITEURL.'login.php');
            } else
            {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
 
 <section class="food-search">
<div class="container">

<body>
    <div class="wrapper">
        <h2 class="text-center text-white">Sign Up</h2>

        <p class="text-center">Please fill this form to create an account.</p>

        <form action="" method="POST" class="order"> 


        <fieldset>

        <div class="order-label">Full Name</div>
            <input type="text" name="full_name" placeholder="Your Name" class="input-responsive" required>

            <div class="order-label">Username</div>
            <input type="text" name="username" placeholder="username" class="input-responsive <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?> <?php echo $username_err; ?>" required>
            


            <div class="order-label">Password</div>
                <input type="password" name="password" class="input-responsive" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?> value="<?php echo $password; ?><?php echo $password_err; ?>">


            <div class="order-label">Confirm Password</div>
                <input type="password" name="confirm_password" class="input-responsive" <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?> value="<?php echo $confirm_password; ?><?php echo $confirm_password_err; ?>">  
          

            
            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            <input type="submit" name="reset" value="Reset" class="btn btn-secondary">
            

        </fieldset>



            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>

</section>



<?php include('partials-front/menu.php'); ?>
