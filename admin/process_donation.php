<?php
include 'db.php'; // Connect to the database

$response = array("status" => "error", "message" => "An unknown error occurred.");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $conn->real_escape_string($_POST['first-name']);
    $last_name = $conn->real_escape_string($_POST['last-name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $amount = floatval($_POST['amount']);
    $bank = $conn->real_escape_string($_POST['bank']);

    // ✅ SERVER-SIDE VALIDATION FOR AMOUNT
    if ($amount <= 0) {
        $response["message"] = "Error: Donation amount must be greater than 0.";
        echo json_encode($response);
        exit();
    }

    // Handle File Upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["proof-of-payment"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = array("jpg", "jpeg", "png", "pdf");

    if (!in_array($file_type, $allowed_types)) {
        $response["message"] = "Error: Only JPG, JPEG, PNG, and PDF files are allowed.";
        echo json_encode($response);
        exit();
    }

    if (move_uploaded_file($_FILES["proof-of-payment"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO donations (first_name, last_name, email, phone, amount, bank, proof_of_payment) VALUES (?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            $response["message"] = "Database Error: " . $conn->error;
            echo json_encode($response);
            exit();
        }

        $stmt->bind_param("ssssdss", $first_name, $last_name, $email, $phone, $amount, $bank, $target_file);

        if ($stmt->execute()) {
            $response["status"] = "success";
            $response["message"] = "Success! Your donation has been recorded.";
        } else {
            $response["message"] = "Database Execution Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $response["message"] = "File upload failed.";
    }
} else {
    $response["message"] = "Invalid request method.";
}

$conn->close();
echo json_encode($response);

?>
