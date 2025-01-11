<?php

// Inialize session
session_start();

// Delete certain session
unset($_SESSION['email']);
unset($_SESSION['user_id']);
unset($_SESSION['user_type']);

session_unset(); 

// Delete all session variables
session_destroy();

// Jump to login page
header('Location: '. $base_url . '/log-in' );

?>