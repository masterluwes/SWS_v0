<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $updates = json_decode($_POST['updates'], true);

    $allowed_fields = ['first_name', 'last_name', 'email', 'phone', 'amount', 'bank'];
    $query_parts = [];

    foreach ($updates as $field => $value) {
        if (!in_array($field, $allowed_fields)) {
            die(json_encode(["status" => "error", "message" => "Invalid field: " . htmlspecialchars($field)]));
        }

        $value = trim($value); // Remove leading/trailing spaces

        // ✅ Ensure amount is valid and non-negative
        if ($field === "amount") {
            $value = str_replace(",", "", $value); // Remove commas
            if (!is_numeric($value) || floatval($value) < 0) {
                die(json_encode(["status" => "error", "message" => "Amount must be a valid number and cannot be negative."]));
            }
            $value = floatval($value); // Convert to float
        }

        $value = $conn->real_escape_string($value);
        $query_parts[] = "$field = '$value'";
    }

    if (!empty($query_parts)) {
        $query = "UPDATE donations SET " . implode(", ", $query_parts) . " WHERE id = $id";
        if ($conn->query($query)) {
            echo json_encode(["status" => "success", "message" => "Donation updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating record: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No valid updates provided."]);
    }
}
?>
