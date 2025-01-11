<?php

$DBhost = "127.0.0.1";
$DBuser = "u147665944_haluzzu";
$DBpassword ="Zulfaqar_30";
$DBname="u147665944_haluzzu_point";

$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname); 

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "Connected successfully"; // Add this line for debugging
}

?>