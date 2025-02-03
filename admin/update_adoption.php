<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $updates = $_POST['updates'];

    $allowed_fields = ['name', 'email', 'phone', 'address', 'birthdate', 'occupation', 'pronouns', 'prompted', 'animal_interest', 'adopt_before']; // ✅ FIXED: Ensure "adopt_before" is included
    $query_parts = [];

    foreach ($updates as $field => $value) {
        if (!in_array($field, $allowed_fields)) {
            die("Invalid field: " . htmlspecialchars($field));
        }

        if ($field == "prompted" && is_array($value)) {
            $value = implode(", ", $value);
        }

        $value = $conn->real_escape_string($value);
        $query_parts[] = "$field = '$value'";
    }

    if (!empty($query_parts)) {
        $query = "UPDATE adoption_forms SET " . implode(", ", $query_parts) . " WHERE id = $id";
        if ($conn->query($query)) {
            echo "Success";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}
?>
