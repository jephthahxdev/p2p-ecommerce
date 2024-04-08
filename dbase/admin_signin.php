<?php
$sessionTimeout = 7200; // 2 hours in seconds
session_set_cookie_params($sessionTimeout);

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('db_conn.php');

// Check if admin is already logged in
if(isset($_SESSION['admin_id'])) {
    header('Location: ../admin/dashboard.php'); // Redirect to the dashboard if logged in
    exit();
}

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_email']= $row['email'];
            $_SESSION['admin_username'] = $row['first_name']; // Storing first name in session

            // Including the JavaScript script here
            echo '<script>
                        if (window.opener) {
                            window.opener.postMessage("loginSuccessful", "*");
                            window.close();
                        } else {
                            window.location.href = "../admin/dashboard.php"; // Redirect to dashboard if no opener window
                        }
                  </script>';
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid password";
            header('Location: ../admin/login.php'); // Redirect back to the login page
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Invalid email";
        header('Location: ../admin/login.php'); // Redirect back to the login page
        exit();
    }
}

// Redirect to login page if not already logged in
// header('Location: ../login.php');
// exit();
?>