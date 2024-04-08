<?php
session_start();
require('db_conn.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../admin/login.php');
    exit();
}

$perPage = 10; // Number of entries per page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Current page (default to 1)

$offset = ($currentPage - 1) * $perPage;
$limit = $perPage;

$sql = "SELECT orders.order_id, orders.user_id, orders.product_name, orders.product_link,
        orders.quantity, orders.paid_amount, orders.vendor, orders.vendor_email, transactions.card_number, orders.timestamp, 
        users.first_name, users.last_name
        FROM orders 
        JOIN users ON orders.user_id = users.id
        JOIN transactions ON orders.order_id = transactions.id
        WHERE orders.status = 'successful'
        ORDER BY orders.timestamp DESC"; // Get orders in descending order

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo   '<td class="c-title">' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
        echo '<td class="c-title" style="text-transform: capitalize;"><a href="../product-details.php?id=' . $row['product_link'] . '">' . $row['product_name'] . '</a></td>';
        echo   '<td class="c-title">' . $row['vendor'] . '</td>';
        echo   '<td class="c-title">' . $row['quantity'] . '</td>';
        echo   '<td class="c-title">' . '£' . $row['paid_amount'] . '</td>';
        echo   '<td class="c-title">' . $row['card_number'] . '</td>';
        echo   '<td class="c-title">' . $row['timestamp'] . '</td>';
        echo   '<td class="c-title"><a href="order-details.php?order_id=' . $row['order_id'] . '&product_link=' . $row['product_link'] . '">Billing Details</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="8">No orders found</td></tr>';
}

$conn->close();
?>