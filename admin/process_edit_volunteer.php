<?php
session_start();
include 'db.php'; // Database connection

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id']) && isset($_POST['updates'])) {
    $id = intval($_POST['id']);
    $updates = json_decode($_POST['updates'], true); // Decode JSON data

    if (!isset($updates['first_name']) || !isset($updates['last_name']) || !isset($updates['email']) || !isset($updates['status'])) {
        echo json_encode(["status" => "error", "message" => "Missing required fields."]);
        exit();
    }

    // Sanitize values
    $first_name = $conn->real_escape_string($updates['first_name']);
    $last_name = $conn->real_escape_string($updates['last_name']);
    $email = $conn->real_escape_string($updates['email']);
    $status = $conn->real_escape_string($updates['status']);

    // ✅ Correctly update the database
    $query = "UPDATE volunteers SET first_name = ?, last_name = ?, email = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $first_name, $last_name, $email, $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database update failed."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>
