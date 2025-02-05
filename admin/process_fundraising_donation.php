<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $bank = $_POST['bank'];

    // Get the correct fundraising name
    $fundraising_name = trim($_POST['fundraising-name']);
    $fundraising_name = preg_replace('/[^A-Za-z0-9\s!]/', '', $fundraising_name); // Remove special characters except (!)

    // Debugging: Log received values
    error_log("Processing donation for: " . $fundraising_name);

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

        // Define goal amounts per fundraiser
        $fundraising_goals = [
            "FUNDRAISING FOR CHUCKY!" => 7000,
            "FUNDRAISING FOR GENERAL" => 12000,
            "HELP GHOST!" => 7500,
            "5PHP FUND DRIVE FOR GRANNY!" => 10000, // ✅ Add Granny's fundraiser
            "5 FUND DRIVE FOR SWS SHELTER RESCUES!" => 10000,
            "JUSTICE FOR HOLLY" => 10000,
            "FUNDRAISING FOR JADE" => 7000,
            "FUNDRAISING FOR MARINA" => 7000
        ];

        $goalAmount = $fundraising_goals[$fundraising_name] ?? 10000; // Default goal
        $progressPercentage = ($data['total_raised'] / $goalAmount) * 100;
        $progressPercentage = min($progressPercentage, 100); // Cap at 100%


        echo json_encode([
            "status" => "success",
            "totalRaised" => $data['total_raised'],
            "donorCount" => $data['donor_count'],
            "progressPercentage" => $progressPercentage
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save donation"]);
    }
}
