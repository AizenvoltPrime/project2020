
<?php

 /* at the top of 'check.php' */
    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        /* 
           Up to you which header to send, some prefer 404 even if 
           the files does exist for security
        */
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );

        /* choose the appropriate page to redirect users */
        die( header( 'location: welcome.php' ) );

    }
define('servername', 'localhost');
define('username', 'root');
define('password', '');
define('dbname', 'project');
$conn = new mysqli(servername, username, password, dbname);

// Check connection
if ($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
?>