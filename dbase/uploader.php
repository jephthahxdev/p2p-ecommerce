<?php
session_start();
// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

require('db_conn.php');

if(isset($_POST['upload'])){
    // Getting the user first name, last name, and email from the session
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $user_id = $_SESSION['user_id'];

    // Product form params
    $product_name = $_POST['productName'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $status = 'active'; // Default status for a new product

    // Generating product links
    $product_link = uniqid();


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

    // Insert product details into the products table
    $sql = "INSERT INTO products (user_id, first_name, last_name, email, product_name, product_link, price, quantity, description, status)
            VALUES ('$user_id', '$first_name', '$last_name', '$email', '$product_name', '$product_link', $price, $quantity, '$description', '$status')";

    if ($conn->query($sql) === TRUE) {
        $product_id = $conn->insert_id;
         // Storing the auto-generated product ID
        $_SESSION['product_id'] = $product_id;

        // Insert image URLs into the images table
        foreach ($imageUrls as $imageUrl) {
            $sql = "INSERT INTO images (product_id, user_id, image_url) 
                    VALUES ($product_id, $user_id, '$imageUrl')";

            if ($conn->query($sql) !== TRUE) {
                $_SESSION['upload_error'] = "Error: " . $sql . "<br>" . $conn->error;
                header("Location: ../product-upload.php"); 
                break; // Exit loop if an error occurs
            }
        }

        $_SESSION['upload_success'] = "Product uploaded successfully";
        header("Location: ../product-upload.php"); 
    } else {
        $_SESSION['upload_error'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: ../product-upload.php"); 
    }
}
?>