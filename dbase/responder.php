<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require('db_conn.php');

if(isset($_POST['reply'])){

    // Reversing user in session roles as sender
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name']; // recipient becomes sender
    $lastName = $_SESSION['last_name'];
    $userEmail = $_SESSION['email'];

    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $enquiry = $_POST['body'];    

    // Reversing sender as user in session
    $vendor = $_POST['firstName']; // sender becomes recipient
    $vendorEmail = $_POST['userEmail'];
    $isOpened = '1';

    $_SESSION['product_id'] = $productId;

    // Handle image uploads
    $imageUrls = [];
    $targetDir = "../uploads/"; // Create a directory named 'uploads' to store the images

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $newFileName = uniqid() . "_" . basename($_FILES['images']['name'][$key]);
        $targetFilePath = $targetDir . $newFileName;

        if (move_uploaded_file($tmp_name, $targetFilePath)) {
            $imageUrls[] = $targetFilePath;
        }
    }

    // Convert $imageUrls array to a comma-separated string
    $imageUrlsString = implode(",", $imageUrls);

    // Insert message details into the messages table with image URLs
    $sql = "INSERT INTO messages (userId, productId, userEmail, vendor, vendorEmail, productName, firstName, lastName, enquiry, is_opened, attachment_url)
            VALUES ('$userId', '$productId', '$userEmail', '$vendor', '$vendorEmail', '$productName', '$firstName', '$lastName', '$enquiry', '$isOpened', '$imageUrlsString')";

    if ($conn->query($sql) === TRUE) {
        $message_id = $conn->insert_id;
        // Storing the auto-generated message ID
        $_SESSION['message_id'] = $message_id;

        $_SESSION['reply_success'] = "message uploaded successfully";
        header("Location: ../message-details.php?id={$productId}"); 
    } else {
        $_SESSION['reply_error'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: ../message-details.php?id={$productId}"); 
    }
}
?>