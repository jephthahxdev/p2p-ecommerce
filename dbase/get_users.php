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

$sql = "SELECT users.id, users.first_name, users.last_name, users.email, users.phone_number, 
        (SELECT SUM(total_price) FROM transactions WHERE transactions.vendor = users.first_name) as earnings 
        FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userId = $row['id'];
        $fullName = $row['first_name'] . ' ' . $row['last_name'];
        $email = $row['email'];
        $phone = $row['phone_number'];
        $earnings = $row['earnings'];

        echo '<tr>';
        echo '<td class="c-title">' . $userId . '</td>';
        echo '<td class="c-title">' . $fullName . '</td>';
        echo '<td class="c-title">' . $email . '</td>';
        echo '<td class="c-title">' . $phone . '</td>';
        echo '<td class="c-title">' . '£' . $earnings . '</td>';
        echo '<td class="c-title"><button class="btn btn-top btn-border" style="margin-top: -2px;" onclick="deleteUser(' . $userId . ')">Delete</button></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">No users found</td></tr>';
}

$conn->close();
?>