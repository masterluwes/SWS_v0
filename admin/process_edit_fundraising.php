<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $updates = json_decode($_POST['updates'], true); // Decode JSON updates

    // Construct the SQL query dynamically
    $update_query = "UPDATE fundraising_donations SET ";
    $params = [];
    $types = "";

    foreach ($updates as $field => $value) {
        $update_query .= "$field = ?, ";
        $params[] = $value;
        $types .= is_numeric($value) ? "i" : "s"; // Determine data type (integer or string)
    }

    $update_query = rtrim($update_query, ", "); // Remove trailing comma
    $update_query .= " WHERE id = ?"; // Add condition
    $params[] = $id;
    $types .= "i"; // ID is always integer

    $stmt = $conn->prepare($update_query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update record"]);
    }
}
?>
