<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $updates = json_decode($_POST['updates'], true);

    // Allowed fields for update, including adoption_status
    $allowed_fields = ['first_name', 'last_name', 'email', 'phone', 'address', 'birthdate', 'occupation', 'pronouns', 'prompted', 'animal_interest', 'adopt_before', 'adoption_status'];
    $query_parts = [];

    foreach ($updates as $field => $value) {
        if (!in_array($field, $allowed_fields)) {
            die(json_encode(["status" => "error", "message" => "Invalid field: " . htmlspecialchars($field)]));
        }

        // Special validation for adoption_status
        if ($field === "adoption_status") {
            $valid_statuses = ['Pending', 'Accepted', 'Rejected'];
            if (!in_array($value, $valid_statuses)) {
                die(json_encode(["status" => "error", "message" => "Invalid adoption status"]));
            }
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
