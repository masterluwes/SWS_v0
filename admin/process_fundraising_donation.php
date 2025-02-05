<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $bank = $_POST['bank'];
    $fundraising_name = trim($_POST['fundraising-name']); // Remove spaces
    $fundraising_name = preg_replace('/[^A-Za-z0-9\s]/', '', $fundraising_name); // Remove special characters like ₱ or !
    $fundraising_name = "5 FUND DRIVE FOR SWS SHELTER RESCUES"; // Force correct name


    // Validate Amount
    if ($amount <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid donation amount"]);
        exit();
    }

    // Handle File Upload
    $proof_path = "";
    if (!empty($_FILES['proof-of-payment']['name'])) {
        $target_dir = "uploads/";
        $proof_path = $target_dir . basename($_FILES["proof-of-payment"]["name"]);
        move_uploaded_file($_FILES["proof-of-payment"]["tmp_name"], $proof_path);
    }

    // Insert into Database
    $stmt = $conn->prepare("INSERT INTO fundraising_donations (first_name, last_name, email, phone, amount, bank, proof_of_payment, fundraising_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisss", $first_name, $last_name, $email, $phone, $amount, $bank, $proof_path, $fundraising_name);

    if ($stmt->execute()) {
        // Get Total Raised for this Fundraiser
        $query = "SELECT SUM(amount) AS total_raised, COUNT(id) AS donor_count FROM fundraising_donations WHERE fundraising_name=?";
        $stmt2 = $conn->prepare($query);
        $stmt2->bind_param("s", $fundraising_name);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $data = $result->fetch_assoc();

        echo json_encode(["status" => "success", "totalRaised" => $data['total_raised'], "donorCount" => $data['donor_count'], "goal" => 10000]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save donation"]);
    }
}
