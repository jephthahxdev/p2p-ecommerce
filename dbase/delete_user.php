<?php
session_start();
// Check if logged in
if (!isset($_SESSION['admin_id'])) {
  header('Location: ../admin/login.php');
  exit();
}

require('db_conn.php');

if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Perform the deletion
    $sql = "DELETE FROM users WHERE id = $userId";
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>