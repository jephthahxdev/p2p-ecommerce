<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to a page after logout (e.g., login page)
header("location: login.php");
exit();
?>