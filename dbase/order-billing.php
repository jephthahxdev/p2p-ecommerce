<?php
session_start();
// Check for errors
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

require('db_conn.php');

if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['select_country']) && isset($_POST['state']) && isset($_POST['address']) && isset($_POST['town_city']) && isset($_POST['postcode']) && isset($_POST['phone'])) {
    // Form was submitted, process the data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $country = $_POST['select_country'];
    $state = $_POST['state'];
    $address = $_POST['address'];
    $town = $_POST['town_city'];
    $postcode = $_POST['postcode'];
    $phone = $_POST['phone'];

    // User session variables
    $userId = $_SESSION['user_id'];
    $email = $_SESSION['email'];

    // Product session variables
    $productLink = $_SESSION['product_id'];
    $quantity = $_SESSION['quantity'];
    $totalPrice = $_SESSION['total_price'];
    $vendor = $_SESSION['vendor'];

    $sql = "INSERT INTO billing (user_id, email, first_name, last_name, country, state_province, address, city, postcode, phone, product_url, vendor) 
            VALUES ('$userId', '$email', '$firstName', '$lastName', '$country', '$state', '$address', '$town', '$postcode', '$phone', '$productLink', '$vendor')";

    if ($conn->query($sql) === TRUE) {
        // Successfully inserted into the database
        $_SESSION['message_success'] = "Response sent successfully";
            header("Location: ../order-payment.php");
        // You can redirect the user to a success page or perform any other actions here
    } else {
        // Error occurred while inserting into the database
        $_SESSION['message_error'] = "Error: " . $sql . "<br>" . $conn->error;
            header("Location: ../order-summary.php");      
        }
} else {
// If someone tries to access this script directly without submitting the form
$_SESSION['message_error'] = "Invalid request" . $conn->error;
    header("Location: ../order-summary.php");
}
$conn->close();
?>