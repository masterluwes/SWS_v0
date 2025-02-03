<?php
// Database connection
include 'db.php';

// Retrieve form data
$name = $_POST['name'];
$age_years = $_POST['age_years'];
$age_months = $_POST['age_months'];
$breed = $_POST['breed'];
$medical_condition = $_POST['medical_condition'];
$disabilities = $_POST['disabilities'];
$description = $_POST['description'];
$gender = $_POST['gender'];
$adopted = $_POST['adopted'];

// Handle file upload
$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Check for file size limit
    if ($_FILES['image']['size'] > 5000000) { // 5MB size limit
        echo "Error: File size exceeds the limit.";
        exit;
    }

    // Validate file type (e.g., only allow images)
    $fileType = mime_content_type($_FILES["image"]["tmp_name"]);
    if (strpos($fileType, "image") === false) {
        echo "Error: Only image files are allowed.";
        exit;
    }

    // Define the target directory
    $targetDir = "uploads/";

    // Ensure the directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create directory if not exists
    }

    // Sanitize file name and generate a unique file name to prevent conflicts
    $fileName = uniqid() . "-" . basename($_FILES["image"]["name"]);
    $imagePath = $targetDir . $fileName;

    // Move the uploaded file to the target directory
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
        echo "Error: File upload failed.";
        exit;
    }
}

// Insert into database
$sql = "INSERT INTO animals (name, age_years, age_months, breed, medical_condition, disabilities, description, gender, adopted, image_path)
        VALUES ('$name', '$age_years', '$age_months', '$breed', '$medical_condition', '$disabilities', '$description', '$gender', '$adopted', '$imagePath')";

if ($conn->query($sql) === TRUE) {
    echo "Animal added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
