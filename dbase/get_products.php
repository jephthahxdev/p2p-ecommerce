<?php
session_start();
// Check if logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: ../login.php');
  exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('db_conn.php');

$perPage = 5; // Number of entries per page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Current page (default to 1)

$offset = ($currentPage - 1) * $perPage;

$sql = "SELECT products.id, products.product_name, products.product_link, 
        (SELECT image_url FROM images WHERE products.id = images.product_id LIMIT 1) as image_url,
        products.price, products.quantity, products.status 
        FROM products 
        WHERE products.user_id = {$_SESSION['user_id']}
        ORDER BY products.id DESC
        LIMIT $offset, $perPage";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $_SESSION['product_id'] = $row['id']; // Storing the id in the session

    echo '<tr>';
    echo '<td class="tt-title"><a href="product-details.php?id=' . $row['product_link'] . '">' . $row['product_name'] . '</a></td>';
    echo '<td class="image-preview"><img src="MarionPeer/' . $row['image_url'] . '" alt="Product Image"></td>';
    echo '<td class="tt-title">' . $row['price'] . '</td>';
    echo '<td class="tt-title">' . $row['quantity'] . '</td>';
    echo '<td class="btn btn-top btn-border">' . $row['status'] . '</td>';
    echo '</tr>';
  }
} else {
  echo '<tr><td colspan="5">No products found</td></tr>';
}

// echo "Page: ".$_GET['page'];

$conn->close();
?>