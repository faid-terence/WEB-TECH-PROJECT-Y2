<?php

require 'dbconfigs.php';


$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($con->connect_error) {
    die("Connection failed: " . $conn -> connect_error);  // die() is a function that stops the script and displays an error
}
else{
    echo "Connected";
}

?>