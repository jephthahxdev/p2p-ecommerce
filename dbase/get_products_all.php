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

$sql = "SELECT products.id, products.product_name, products.product_link,
        (SELECT image_url FROM images WHERE products.id = images.product_id LIMIT 1) as image_url,
        CONCAT(products.first_name, ' ', products.last_name) as vendor,
        products.price, products.quantity, products.status 
        FROM products 
        ORDER BY products.id DESC"; // Get products in descending order

$sql .= " LIMIT $offset, $limit";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productId = $row['id'];

        echo '<tr>';
        echo '<td class="c-title">' . $row['id'] . '</td>';
        echo '<td class="c-title" style="text-transform: capitalize;"><a href="../product-details.php?id=' . $row['product_link'] . '">' . $row['product_name'] . '</a></td>';
        echo '<td class="image-preview"><img src="MarionPeer/../' . $row['image_url'] . '" alt="Product Image"></td>';
        echo '<td class="c-title" style="text-transform: capitalize;">' . $row['vendor'] . '</td>';
        echo '<td class="c-title">' . '£' . $row['price'] . '</td>';
        echo '<td class="c-title">' . $row['quantity'] . '</td>';
        echo '<td class="c-title"><button class="btn btn-top btn-border" style="text-transform: capitalize; margin-top: -2px;">' . $row['status'] . '</button></td>';
        echo '<td class="c-title"><button class="btn btn-top btn-border" style="margin-top: -2px;" onclick="deleteProduct(' . $productId . ')">Delete</button></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="7">No products found</td></tr>';
}

$conn->close();
?>