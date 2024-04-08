<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// Check if logged in
if (!isset($_SESSION['admin_id'])) {
  header('Location: ../admin/login.php');
  exit();
}

require('db_conn.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Step 1: Delete Associated Images
    $delete_images_query = "DELETE FROM images WHERE product_id = $product_id";
    $conn->query($delete_images_query);

    // Step 2: Delete the Product
    $delete_product_query = "DELETE FROM products WHERE id = $product_id";
    if ($conn->query($delete_product_query) === TRUE) {
        echo "Product deleted successfully";
    } else {
        echo "Error deleting product: " . $conn->error;
    }

} else {
    echo "Product ID not provided";
}

// Close the database connection
$conn->close();
?>