<?php
$servername = "localhost"; // Use 127.0.0.1 instead of localhost
$username = "root";
$password = ""; // Default XAMPP password is empty
$database = "stray_worth_saving";
$port = 3306; // Explicitly specify port

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful!";
}
