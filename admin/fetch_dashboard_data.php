<?php
include '../admin/db.php'; // Database connection

header('Content-Type: application/json'); // JSON response

// ✅ Get total number of adoptions from the animals table
$query_adoptions = "SELECT COUNT(*) AS adopted_pets FROM animals WHERE adopted = 1";
$result_adoptions = $conn->query($query_adoptions);
$total_adoptions = ($result_adoptions->num_rows > 0) ? $result_adoptions->fetch_assoc()['adopted_pets'] : 0;

// ✅ Get total donation amount from donations table
$query_donations = "SELECT IFNULL(SUM(amount), 0) AS total_donations FROM donations";
$result_donations = $conn->query($query_donations);
$total_donations = ($result_donations->num_rows > 0) ? $result_donations->fetch_assoc()['total_donations'] : 0;

// ✅ Get total fundraising amount from fundraising_donations table
$query_fundraising = "SELECT IFNULL(SUM(amount), 0) AS total_fundraising FROM fundraising_donations";
$result_fundraising = $conn->query($query_fundraising);
$total_fundraising = ($result_fundraising->num_rows > 0) ? $result_fundraising->fetch_assoc()['total_fundraising'] : 0;

// Return JSON data
echo json_encode([
    "totalAdoptions" => $total_adoptions,
    "totalDonations" => $total_donations,
    "totalFundraising" => $total_fundraising
]);

$conn->close();
?>
