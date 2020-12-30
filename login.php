<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate credentials
    if (empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM user WHERE username = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $_POST["username"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($_POST["password"], $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            

                            // Redirect user to welcome page
                            header('Location: welcome.php');
                        } else{
                            // Display an error message if password is not valid
                            echo "Wrong Password";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    echo "Wrong Username";
                }
            } else{
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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <style type="text/css">
        .heading{
            padding-top:11%;
            text-align:center;
        }
        h2{
            text-align:left;
        }
        .small-space{
            padding:1%;
        }
    </style>
</head>
<body>
        <div class="heading">
        </div>
        <div class="small-space"></div>
        <form class="my-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <ul class="flex-login">
            <li>
                <h2>Login</h2>
                <p>Please fill in your credentials to login.</p>
            </li>
            <li>
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
            </li>
            <br>
            <li> 
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </li>
            <li>
                <br>
                <input type="button" class="btn btn-primary" value="Login" onclick="login_validation()">
            <li>
            <p>Don't have an account? <a class="Sign-up" href="registration.php">Sign up now</a>.</p>
        </ul>
        </form>
</body>
</html>