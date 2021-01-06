<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../welcome.php");
    exit;
}

// Include config file
require_once "../config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style type="text/css">
        h2{
            text-align:left;
        }
        .small-space{
            padding:4%;
        }

        h2{
            margin-bottom:0;
        }

        .small-margin{
            padding:1%;
        }
    </style>
</head>
<body class="preload" id="logBody">
        <div class="small-space"></div>
        <form id="login-form" name="login-form">
            <div id="login-red-box"></div>
        <ul class="flex-login">
            <li>
                <h2>Login</h2>
                <p>Please fill in your credentials to login.</p>
            </li>
            <li>
                <label class="label-color">Username</label>
                <input type="text" name="username" class="form-control">
                <div class="small-margin"> </div>
                <span id="user-help"></span>
            </li>
            <br>
            <li> 
                <label class="label-color">Password</label>
                <input type="password" name="password" class="form-control">
                <div class="small-margin"> </div>
                <span id="pass-help"></span>
            </li>
            <li>
                <br>
                <input id= "sum" type="button" value="Login" onclick="login_validation()">
            <li>
            <p>Don't have an account? <a class="Sign-up" href="../registration/registration.php">Sign up now</a>.</p>
        </ul>
        </form>
        <script src="login.js"></script>
        <div class="ocean">
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
        <audio autoplay preload='auto' loop id="myAudio">
            <source src="../audio-files/Nightcore - River Flows In You.mp3" type="audio/mpeg" >
        </audio>
</body>
</html>