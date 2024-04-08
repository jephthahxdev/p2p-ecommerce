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
$limit = $perPage;

// Fetch orders data
$sql = "SELECT orders.order_id as id, 'order' AS transaction_type, orders.product_name, orders.quantity, orders.paid_amount AS total_price, orders.timestamp
        FROM orders
        INNER JOIN products ON products.product_link = orders.product_link
        WHERE orders.user_id = '{$_SESSION['user_id']}'
        
        UNION ALL
        
        SELECT transactions.id, 'purchase' AS transaction_type, transactions.product_name, transactions.quantity, transactions.total_price, transactions.timestamp
        FROM transactions
        WHERE transactions.user_id = '{$_SESSION['user_id']}'
        
        ORDER BY timestamp DESC";

$sql .= " LIMIT $offset, $limit";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        // Table data for id, transaction type, product name, quantity, price, status, timestamp
        echo '<td style="color:#2879fd">' . '#' . $row['id'] . '</td>';
        echo '<td>' . $row['transaction_type'] . '</td>';
        echo '<td>' . $row['product_name'] . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . '£' . $row['total_price'] . '</td>';
        echo '</tr>';
    }
} else {
    echo "<tr><td colspan='5'>No orders found</td></tr>";
}

$conn->close();
?>