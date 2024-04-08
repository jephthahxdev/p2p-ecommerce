<?php
session_start();
// Check if logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../admin/login.php');
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('db_conn.php');

$sql = "SELECT products.id, products.product_name, products.product_link, 
        (SELECT image_url FROM images WHERE products.id = images.product_id LIMIT 1) as image_url,
        products.price, products.quantity, products.status 
        FROM products 
        WHERE products.status = 'sold'
        ORDER BY products.id DESC
        LIMIT 5"; // Limit to 5 most recent products

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td class="tt-title"><a href="product-details.php?id=' . $row['product_link'] . '">' . $row['product_name'] . '</a></td>';
        echo '<td class="image-preview"><img src="MarionPeer/../' . $row['image_url'] . '" alt="Product Image"></td>';
        echo '<td class="tt-title">' . '£' . $row['price'] . '</td>';
        echo '<td class="tt-title">' . $row['quantity'] . '</td>';
        echo '<td class="btn btn-top btn-border">' . $row['status'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5" style="font-size: 14px; text-transform: none; font-weight: 500;">No products found</td></tr>';
}

$conn->close();
?>