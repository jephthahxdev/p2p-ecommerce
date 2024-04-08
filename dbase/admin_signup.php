<?php
require('db_conn.php');
session_start(); // Start the session

// Check if admin is already logged in
if(isset($_SESSION['admin_id'])) {
    header('Location: ../admin/dashboard.php'); // Redirect to the dashboard if logged in
    exit();
}

// Admin Registration
if(isset($_POST['register'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];

    // Validate email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['registration_error'] = "Invalid email format. Please provide a valid email address.";
        header('Location: ../register.php');
        exit();
    }

    // Validate phone number (basic check for digits and length)
    if (!preg_match("/^[0-9]{11}$/", $phone_number)) {
        $_SESSION['registration_error'] = "Invalid phone number. Please provide a 11-digit numeric phone number.";
        header('Location: ../register.php');
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert values into dbase
    $sql = "INSERT INTO admin (first_name, last_name, email, phone_number, password)
    VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['registration_success'] = "Registration successful";
        header('Location: ../admin/login.php'); // Redirect to the login page
        exit();
    } else {
        $_SESSION['registration_error'] = "Error: " . $sql . "<br>" . $conn->error;
        header('Location: ../admin/register.php');
        exit();
    }
}
?>