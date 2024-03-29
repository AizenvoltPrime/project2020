<?php
// Initialize the session
session_start();

// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$username_err = $password_err = "";
// Processing form data when form is submitted

        $sql = "SELECT id, username, password, role FROM user WHERE username = ?";
        
        if ($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $_POST['username'];
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($_POST['password'], $hashed_password)){
                            // Password is correct, so start a new session             
                            // Store data in session variables
                            echo "Success";
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            if($role == "admin")
                            {
                                $_SESSION["role"] = "admin";
                            }
                            else{
                                $_SESSION["role"] = "user";
                            }                 
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
                echo "Oops! Something went wrong! Please try again later!";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    
    // Close connection
    mysqli_close($conn);

?>