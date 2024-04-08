<?php
session_start();
require('db_conn.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$perPage = 5; // Number of entries per page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Current page (default to 1)

$offset = ($currentPage - 1) * $perPage;

// Fetch orders data
$sql = "SELECT users.first_name, users.last_name, orders.order_id, orders.product_name, orders.product_link, orders.quantity, orders.paid_amount, orders.status, orders.timestamp 
        FROM orders 
        INNER JOIN users ON orders.user_id = users.id 
        WHERE orders.vendor_email = '{$_SESSION['email']}'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo   '<td class="tt-title">' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
        echo   '<td>' . $row['product_name'] . '</td>';
        echo   '<td>' . $row['quantity'] . '</td>';
        echo   '<td>' . '£' . $row['paid_amount'] . '</td>';
        echo   '<td>' . $row['status'] . '</td>';
        echo   '<td>' . $row['timestamp'] . '</td>';
        echo   '<td><a href="order-details.php?order_id=' . $row['order_id'] . '&product_link=' . $row['product_link'] . '">Billing Details</a></td>';
        echo   '</tr>';
    }
} else {
    echo "<tr><td colspan='7'>No orders found</td></tr>";
}

$conn->close();
?>