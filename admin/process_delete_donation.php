<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Fetch proof of payment file path before deleting
    $query = "SELECT proof_of_payment FROM donations WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($proof_of_payment);
    $stmt->fetch();
    $stmt->close();

    // Delete record from the database
    $deleteQuery = "DELETE FROM donations WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Delete the proof of payment file if it exists
        if (!empty($proof_of_payment) && file_exists($proof_of_payment)) {
            unlink($proof_of_payment);
        }
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
