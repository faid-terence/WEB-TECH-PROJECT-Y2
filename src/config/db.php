<?php

require 'dbconfigs.php';


$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($con->connect_error) {
    die("Connection failed: " . $conn -> connect_error);
}
else{
    echo "Connected";
}

?>