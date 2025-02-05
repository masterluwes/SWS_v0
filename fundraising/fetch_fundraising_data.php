<?php
include '../admin/db.php';

header('Content-Type: application/json'); // Ensure JSON response
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

// Retrieve fundraising name from the request
if (!isset($_GET['fundraising_name'])) {
    echo json_encode(["status" => "error", "message" => "No fundraising name provided"]);
    exit();
}

$fundraising_name = trim($_GET['fundraising_name']);
// $fundraising_name = preg_replace('/[^A-Za-z0-9\s!]/', '', $fundraising_name); // Allow special characters like "!"

// Log the fundraising name used
error_log("Fetching donations for: " . $fundraising_name);

// Fetch total donations and donor count
$query = "SELECT IFNULL(SUM(amount), 0) AS total_raised, COUNT(id) AS donor_count 
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
error_log("Fetched Data for $fundraising_name: " . json_encode($data));

$totalRaised = $data['total_raised'] ?? 0;
$donorCount = $data['donor_count'] ?? 0;

// Define goal amounts per fundraiser
$fundraising_goals = [
    "FUNDRAISING FOR CHUCKY!" => 7000,
    "FUNDRAISING FOR GENERAL" => 12000,
    "HELP GHOST!" => 7500,
    "5PHP FUND DRIVE FOR GRANNY!" => 10000, // ✅ Add Granny's fundraiser
    "5 FUND DRIVE FOR SWS SHELTER RESCUES!" => 10000,
    "JUSTICE FOR HOLLY" => 10000,
    "FUNDRAISING FOR JADE" => 7000,
    "FUNDRAISING FOR MARINA" => 7000,
    "HELP ROSS!" => 60000
];

$goalAmount = $fundraising_goals[$fundraising_name] ?? 10000; // Default goal
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
