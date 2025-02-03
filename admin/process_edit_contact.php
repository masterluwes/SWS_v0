<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $updates = json_decode($_POST['updates'], true);

    $setString = "";
    foreach ($updates as $field => $value) {
        $setString .= "$field = '$value', ";
    }
    $setString = rtrim($setString, ", ");

    $query = "UPDATE contacts SET $setString WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error."]);
    }

    $stmt->close();
    $conn->close();
}
?>
