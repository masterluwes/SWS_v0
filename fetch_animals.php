<?php
// Database connection
include 'db.php';

// Fetch animals from the database
$query = "SELECT * FROM animals WHERE adopted = 0"; // Only fetch animals that are not adopted
$animals_result = $conn->query($query);
$animals = [];

while ($row = $animals_result->fetch_assoc()) {
    // Ensure the image path is correct
    if ($row['image_path']) {
        // Adjust the path to include the 'admin' folder
        $row['image'] = 'admin/uploads/' . basename($row['image_path']);
    } else {
        // Provide a default image relative to the current structure
        $row['image'] = 'admin/uploads/default-image.jpg';
    }

    // Add all necessary fields to the animal data array
    $animals[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'description' => $row['description'],
        'breed' => $row['breed'],
        'gender' => $row['gender'],
        'age_years' => $row['age_years'],
        'age_months' => $row['age_months'],
        'medical_condition' => $row['medical_condition'], // Add medical_condition
        'disabilities' => $row['disabilities'],           // Add disabilities
        'date_added' => $row['created_at'],               // Add date_added
        'image' => $row['image']
    ];
}

$conn->close();

// Return the data as JSON
echo json_encode($animals);
?>
