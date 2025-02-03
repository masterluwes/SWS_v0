<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$database = "stray_worth_saving";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit();
}

// Validate form data
$errors = [];

if (!isset($_POST['first_name']) || empty(trim($_POST['first_name']))) {
    $errors[] = "First Name is required.";
}

if (!isset($_POST['last_name']) || empty(trim($_POST['last_name']))) {
    $errors[] = "Last Name is required.";
}

if (!isset($_POST['email']) || empty(trim($_POST['email']))) {
    $errors[] = "Email is required.";
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

// If errors exist, return JSON error response
if (!empty($errors)) {
    echo json_encode(["status" => "error", "message" => implode("<br>", $errors)]);
    exit();
}

// Sanitize form inputs
$first_name = $conn->real_escape_string(trim($_POST['first_name']));
$last_name = $conn->real_escape_string(trim($_POST['last_name']));
$email = $conn->real_escape_string(trim($_POST['email']));

// ✅ Check if the email is already registered
$check_query = "SELECT id FROM volunteers WHERE email = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("s", $email);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "This email is already registered as a volunteer."]);
    exit();
}

// ✅ Insert data into the database
$stmt = $conn->prepare("INSERT INTO volunteers (first_name, last_name, email) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $first_name, $last_name, $email);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Thank you for signing up as a volunteer!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error submitting form. Please try again."]);
}

$conn->close();
?>
