<?php include('partials-front/menu.php'); ?>

<?php
// Initialize the session

session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
{
    header('location:'.SITEURL);
    exit;
}
 
// Include config file
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
 
    // Check if username is empty
    if(empty(trim($_POST["username"])))
    {
        $username_err = "Please enter username.";
    } 
    else
    {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"])))
    {
        $password_err = "Please enter your password.";
    } 
    else
    {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM tbl_users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1)
                {                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header('location:'.SITEURL);
                        } 
                        else
                        {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } 
                else
                {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
        <h2 class="text-center text-white">Log In</h2>

        <p class="text-center">Please fill in your credentials to login.</p>
<body>
   

        <?php 
        if(!empty($login_err))
        {
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="" method="post">
    
        <fieldset>

        <div class="order-label">Username</div>
                <input type="text" name="username" class="input-responsive <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?><?php echo $username_err; ?>">
                
  
                <div class="order-label">Password</div>
                <input type="password" name="password" class="input-responsive <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?><?php echo $password_err; ?>">
        

            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>

    </fieldset>

    </section>

<?php include('partials-front/footer.php'); ?>