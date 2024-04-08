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

if(isset($_POST['pay'])){
    // Getting the first name, last name, and email from the session
    $userId = $_SESSION['user_id'];
    $firstName = $_SESSION['first_name'];
    $lastName = $_SESSION['last_name'];

    // Getting product page details
    $productName = $_POST['product_name'];
    $quantityPurchased = $_SESSION['quantity'];
    $totalPrice = $_SESSION['total_price'];
    $vendor = $_SESSION['vendor'];
    $productLink = $_SESSION['product_id'];

    // Posting card details
    $cardholder = $_POST['cardHolder'];
    $cardnumber = $_POST['cardNumber'];
    $lastFourDigits = substr($cardnumber, -4); // Get the last four digits

    // Updating the products table to subtract the purchased quantity
    $sqlUpdateQuantity = "UPDATE products SET quantity = quantity - $quantityPurchased WHERE product_link = '$productLink'";
    $conn->query($sqlUpdateQuantity);

    // Checking if the quantity has reached 0, and if so, update the status
    $sqlCheckQuantity = "SELECT quantity FROM products WHERE product_link = '$productLink'";
    $result = $conn->query($sqlCheckQuantity);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newQuantity = $row['quantity'];

        if ($newQuantity == 0) {
            // Updating status to 'Sold'
            $sqlUpdateStatus = "UPDATE products SET status = 'Sold' WHERE product_link = '$productLink'";
            $conn->query($sqlUpdateStatus);
        }
    }

    // Inserting data into the orders table.
    $sqlInsertOrder = "INSERT INTO orders (user_id, product_name, product_link, quantity, paid_amount, vendor, status)
    VALUES ('$userId', '$productName', '$productLink', '$quantityPurchased', '$totalPrice', '$vendor', 'Successful')";

    $conn->query($sqlInsertOrder); // Executing the Order SQL statement

    // Encrypting the card number for storage (in a real scenario, use proper encryption methods)
    $encryptedCardNumber = str_repeat('*', strlen($cardnumber) - 4) . $lastFourDigits;

    $sql = "INSERT INTO transactions (user_id, first_name, last_name, product_name, quantity, vendor, card_holder, card_number, total_price, status) 
            VALUES ('$userId', '$firstName', '$lastName', '$productName', '$quantityPurchased', '$vendor', '$cardholder', '$encryptedCardNumber', '$totalPrice', 'Successful')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        unset($_SESSION['is_order_initiated']); // Add this line to unset the session variable
        header('Location: ../success.php');
        exit();
    } else {
        $_SESSION['payment_error'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: ../order-payment.php");
    }

}
// Close the database connection
$conn->close();
?>