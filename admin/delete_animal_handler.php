<?php

include 'db.php';

// Check if 'id' is set and is a valid number
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $animalId = $_POST['id'];

    // First, get the image path from the database to delete the image file if it exists
    $sql = "SELECT image_path FROM animals WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $animalId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the image path
        $row = $result->fetch_assoc();
        $imagePath = $row['image_path'];

        // Delete the image file if it exists
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath); // Delete the image file
        }

        // Delete the animal record from the database
        $deleteSql = "DELETE FROM animals WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $animalId);

        if ($deleteStmt->execute()) {
            echo "Animal deleted successfully!";
        } else {
            echo "Error: Could not delete animal from the database.";
        }
    } else {
        echo "Error: Animal not found.";
    }

    // Close the prepared statements and the database connection
    $stmt->close();
    $deleteStmt->close();
    $conn->close();
} else {
    echo "Error: Invalid animal ID.";
}
?>
