<?php

$DBhost = "localhost";
$DBuser = "root";
$DBpassword ="";
$DBname="haluzzu_db";

$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname); 

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully"; // Add this line for debugging
}

?>