<?php
session_start();

// Include the database connection file (db_conn.php)
require 'db_conn.php';

$perPage = 10; // Number of entries per page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; // Current page (default to 1)

$offset = ($currentPage - 1) * $perPage;

// Subquery to get latest timestamp for each productName
$subquery = "(SELECT MAX(timestamp) AS max_timestamp FROM messages GROUP BY productName) AS sub";

$sql = "SELECT messages.id, messages.productId, messages.vendorEmail, messages.firstName, messages.lastName,
        messages.productName, messages.enquiry, messages.timestamp,
        IF(messages.timestamp = sub.max_timestamp AND messages.is_opened = 0, 1, 0) AS is_new
        FROM messages 
        INNER JOIN " . $subquery . " ON sub.max_timestamp = messages.timestamp 
        WHERE messages.vendorEmail = ?
        ORDER BY sub.max_timestamp DESC
        LIMIT ?, ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sii', $_SESSION['email'], $offset, $perPage);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Storing the id in the session
        $_SESSION['product_id'] = $row['productId'];

        // Determine the class for the message based on is_new flag
        $messageClass = $row['is_new'] ? 'unopened-message' : 'opened-message';

        echo '<tr>';
        echo '<td class="tt-title ' . $messageClass . '">' . $row['firstName'] . ' ' . $row['lastName'] . '</td>';
        echo '<td class="tt-title ' . $messageClass . '">' . $row['productName'] . '</td>';
        echo '<td class="tt-title ' . $messageClass . '">' . $row['enquiry'] . '</td>';
        echo '<td class="tt-title ' . $messageClass . '">' . date('F d, Y', strtotime($row['timestamp'])) .'</td>';
        echo '<td><a class="btn btn-top btn-border" style="margin-top: -2px !important;" href="message-details.php?id=' 
             .$row['productId'] .'">View</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">No messages found</td></tr>';
}

$stmt->close();
$conn->close();
?>