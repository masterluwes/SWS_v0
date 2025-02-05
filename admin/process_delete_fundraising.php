<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Delete proof of payment file if it exists
    $query = "SELECT proof_of_payment FROM fundraising_donations WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($proof_of_payment);
    $stmt->fetch();
    $stmt->close();

    if (!empty($proof_of_payment) && file_exists($proof_of_payment)) {
        unlink($proof_of_payment); // Delete file from server
    }

    // Delete the record from the database
    $delete_query = "DELETE FROM fundraising_donations WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete record"]);
    }
}
?>
