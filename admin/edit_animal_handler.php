<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $animalId = $_POST['id'];
    $name = $_POST['name'];
    $ageYears = $_POST['age_years'];
    $ageMonths = $_POST['age_months'];
    $breed = $_POST['breed'];
    $medicalCondition = $_POST['medical_condition'];
    $disabilities = $_POST['disabilities'];
    $description = $_POST['description'];
    $gender = $_POST['gender'];
    $adopted = $_POST['adopted'];

    // Handle image upload if present
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

    // Update animal details in the database
    if ($imagePath !== null) {
        // If a new image is uploaded, update with the new image path
        $query = "UPDATE animals SET 
                    name = ?, 
                    age_years = ?, 
                    age_months = ?, 
                    breed = ?, 
                    medical_condition = ?, 
                    disabilities = ?, 
                    description = ?, 
                    gender = ?, 
                    adopted = ?, 
                    image_path = ? 
                  WHERE id = ?";
    } else {
        // If no new image is uploaded, update without changing the image path
        $query = "UPDATE animals SET 
                    name = ?, 
                    age_years = ?, 
                    age_months = ?, 
                    breed = ?, 
                    medical_condition = ?, 
                    disabilities = ?, 
                    description = ?, 
                    gender = ?, 
                    adopted = ? 
                  WHERE id = ?";
    }

    $stmt = $conn->prepare($query);
    
    if ($imagePath !== null) {
        $stmt->bind_param('siisssssssi', $name, $ageYears, $ageMonths, $breed, $medicalCondition, $disabilities, $description, $gender, $adopted, $imagePath, $animalId);
    } else {
        $stmt->bind_param('siisssssss', $name, $ageYears, $ageMonths, $breed, $medicalCondition, $disabilities, $description, $gender, $adopted, $animalId);
    }

    if ($stmt->execute()) {
        echo "Animal details updated successfully!";
    } else {
        echo "Error updating animal details.";
    }

    $stmt->close();
    $conn->close();
}
?>
