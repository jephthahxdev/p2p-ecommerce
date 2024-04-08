<?php
$servername = "localhost";
$username = "Marion";
$password = "k,@BJOOr^utX";
$dbname = "marionpeer";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>