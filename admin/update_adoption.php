<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $updates = json_decode($_POST['updates'], true);

    $allowed_fields = ['first_name', 'last_name', 'email', 'phone', 'address', 'birthdate', 'occupation', 'pronouns', 'prompted', 'animal_interest', 'adopt_before'];
    $query_parts = [];

    foreach ($updates as $field => $value) {
        if (!in_array($field, $allowed_fields)) {
            die(json_encode(["status" => "error", "message" => "Invalid field: " . htmlspecialchars($field)]));
        }

        $value = $conn->real_escape_string($value);
        $query_parts[] = "$field = '$value'";
    }

    if (!empty($query_parts)) {
        $query = "UPDATE adoption_forms SET " . implode(", ", $query_parts) . " WHERE id = $id";
        if ($conn->query($query)) {
            echo json_encode(["status" => "success", "message" => "Record updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating record: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No valid updates provided."]);
    }
}
?>
