<?php
include 'db.php';

$animalId = $_GET['id'];

$query = "SELECT * FROM animals WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $animalId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $animal = $result->fetch_assoc();
    
    // Ensure 'adopted' is returned as a boolean
    $animal['adopted'] = (bool)$animal['adopted']; // Convert 1/0 to true/false

    // Set image path
    $animal['image'] = $animal['image_path'] ? 'uploads/' . basename($animal['image_path']) : null;

    echo json_encode($animal);
} else {
    echo json_encode(['error' => 'Animal not found.']);
}

$stmt->close();
$conn->close();
?>
