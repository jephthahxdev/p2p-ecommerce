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
$sql = "SELECT products.product_link, products.product_name, users.phone_number, transactions.user_id, transactions.product_name, transactions.quantity, transactions.vendor, transactions.total_price, transactions.status, transactions.timestamp
        FROM transactions
        INNER JOIN products ON products.product_name = transactions.product_name
        INNER JOIN users ON users.first_name = transactions.vendor
        WHERE transactions.user_id = '{$_SESSION['user_id']}'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo   '<td><a href="product-details.php?id=' . $row['product_link'] . '">' . $row['product_name'] . '</td>';
        echo   '<td>' . $row['vendor'] . '</td>';
        echo   '<td>' . $row['phone_number'] . '</td>';
        echo   '<td>' . $row['quantity'] . '</td>';
        echo   '<td>' . '£' . $row['total_price'] . '</td>';
        echo   '<td style="color:green;">' . $row['status'] . '</td>';
        echo   '<td>' . $row['timestamp'] . '</td>';
        echo   '</tr>';
    }
} else {
    echo "<tr><td colspan='6'>No orders found</td></tr>";
}

$conn->close();
?>