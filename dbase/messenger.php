<?php
session_start();
// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

require('db_conn.php');

if(isset($_POST['sendmessage'])){
    // Getting the first name, last name, and email from the session
    $firstName = $_SESSION['first_name'];
    $lastName = $_SESSION['last_name'];
    $userEmail = $_SESSION['email'];
    $userId = $_SESSION['user_id'];

    // Getting product page details
    $productLink = $_POST['productLink'];
    $productId = $_POST['productId'];
    $vendor = $_POST['vendor'];
    $vendorEmail = $_POST['vendorEmail'];
    $productName = $_POST['productName'];

    // Getting message field
    $enquiry = $_POST['enquiry'];

    $sql = "INSERT INTO messages (productId, userId, vendor, vendorEmail, productName, firstName, lastName, userEmail, enquiry) 
            VALUES ('$productId', '$userId', '$vendor', '$vendorEmail', '$productName', '$firstName', '$lastName', '$userEmail', '$enquiry')";

    if ($conn->query($sql) === TRUE) {
        // Successfully inserted into the database
        $_SESSION['message_success'] = "Message sent successfully";
        header("Location: ../product-details.php?id=$productLink");
        // You can redirect the user to a success page or perform any other actions here
    } else {
        // Error occurred while inserting into the database
        $_SESSION['message_error'] = "Error: " . $sql . "<br>" . $conn->error;
                header("Location: ../product-details.php?id=$productLink");      
        }
    } else {
        // If someone tries to access this script directly without submitting the form
        $_SESSION['message_error'] = "Invalid request" . $conn->error;
            header("Location: ../product-details.php?id=$productLink");
    }
$conn->close();
?>