<?php
include 'db.php';

// Get the start and end date of the current week
$start_date = date('Y-m-d', strtotime('last sunday'));
$end_date = date('Y-m-d', strtotime('next saturday'));

// Query to fetch donation data for the current week
$query = "
    SELECT 
        DATE(submission_date) AS donation_date, 
        SUM(amount) AS total_amount
    FROM donations 
    WHERE submission_date BETWEEN '$start_date' AND '$end_date'
    GROUP BY DATE(submission_date)
    ORDER BY donation_date ASC
";

$result = $conn->query($query);

// Initialize an array with zero values for each day of the week
$weekDays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
$donationData = array_fill_keys($weekDays, 0); 

// Process fetched data
while ($row = $result->fetch_assoc()) {
    $dayName = date('l', strtotime($row['donation_date'])); // Convert date to day name
    $donationData[$dayName] = (float) $row['total_amount']; // Store the amount in the corresponding day
}

// Return JSON response
echo json_encode($donationData);
?>
