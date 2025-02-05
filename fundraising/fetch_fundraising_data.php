<?php
include '../admin/db.php';

header('Content-Type: application/json'); // Ensure JSON response
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

$fundraising_name = trim("5 FUND DRIVE FOR SWS SHELTER RESCUES");
$fundraising_name = preg_replace('/[^A-Za-z0-9\s]/', '', $fundraising_name);


// Log the fundraising name used
error_log("Fetching donations for: " . $fundraising_name);

// Check if data exists for this fundraiser
$query_test = "SELECT COUNT(*) AS exists_check FROM fundraising_donations WHERE fundraising_name = ?";
$stmt_test = $conn->prepare($query_test);
$stmt_test->bind_param("s", $fundraising_name);
$stmt_test->execute();
$result_test = $stmt_test->get_result();
$data_test = $result_test->fetch_assoc();

if ($data_test['exists_check'] == 0) {
    error_log("No records found for fundraising name: " . $fundraising_name);
}

// Fetch total donations and donor count
$query = "SELECT COALESCE(SUM(amount), 0) AS total_raised, COUNT(id) AS donor_count 
          FROM fundraising_donations 
          WHERE fundraising_name = ?";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die(json_encode(["status" => "error", "message" => "SQL Error: " . $conn->error]));
}

$stmt->bind_param("s", $fundraising_name);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Log fetched data for debugging
error_log("Fetched Data: " . json_encode($data));

$totalRaised = $data['total_raised'] ?? 0;
$donorCount = $data['donor_count'] ?? 0;
$goalAmount = 10000;
$progressPercentage = ($totalRaised / $goalAmount) * 100;
$progressPercentage = min($progressPercentage, 100); // Cap at 100%

// Return JSON response
echo json_encode([
    "totalRaised" => $totalRaised,
    "donorCount" => $donorCount,
    "progressPercentage" => $progressPercentage
]);

$stmt->close();
$conn->close();
?>
