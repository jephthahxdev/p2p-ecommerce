<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require('db_conn.php');

// Retrieve values from URL parameters
$productLink = $_GET['product_id'];
$quantity = $_GET['quantity'];
$totalPrice = $_GET['total_price'];

// Store relevant information in session variables.
$_SESSION['product_id'] = $productLink; // Adjust this to match your session variable naming conventions
$_SESSION['quantity'] = $quantity;
$_SESSION['total_price'] = $totalPrice;

// Redirect to order-summary page
header("Location: ../order-summary.php");
exit();
?>