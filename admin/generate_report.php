<?php
// Prevent unwanted output before PDF headers
ob_start();

require_once __DIR__ . '/../vendor/autoload.php';

// Create a new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator('Strays Worth Saving');
$pdf->SetAuthor('SWS Admin');
$pdf->SetTitle('Dashboard Report');
$pdf->SetSubject('Generated Report');
$pdf->SetKeywords('PDF, SWS, report, adoption, donation, fundraising');

// Set default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Set the timezone to the Philippines
date_default_timezone_set('Asia/Manila');

// Get the current date and time in Philippine timezone
$reportDate = date('F d, Y h:i A'); // Example: "February 04, 2025 10:30 AM"
$todayDate = date('Y-m-d'); // Format for database comparison (YYYY-MM-DD)

// Fetch data (Make sure your database connection is correct)
include '../admin/db.php';

// Fetch adoption statistics
$total_pets_query = "SELECT COUNT(*) AS total_pets FROM animals";
$total_pets_result = $conn->query($total_pets_query);
$total_pets_data = $total_pets_result->fetch_assoc();
$total_pets = $total_pets_data['total_pets'];

$adopted_pets_query = "SELECT COUNT(*) AS adopted_pets FROM animals WHERE adopted = 1";
$adopted_pets_result = $conn->query($adopted_pets_query);
$adopted_pets_data = $adopted_pets_result->fetch_assoc();
$adopted_pets = $adopted_pets_data['adopted_pets'];

// Fetch total donations
$total_donations_query = "SELECT IFNULL(SUM(amount), 0) AS total_donations FROM donations";
$total_donations_result = $conn->query($total_donations_query);
$total_donations_data = $total_donations_result->fetch_assoc();
$total_donations = $total_donations_data['total_donations'];

// Fetch today's donations (using `submission_date` for donations)
$today_donations_query = "SELECT IFNULL(SUM(amount), 0) AS today_donations FROM donations WHERE DATE(submission_date) = '$todayDate'";
$today_donations_result = $conn->query($today_donations_query);
$today_donations_data = $today_donations_result->fetch_assoc();
$today_donations = $today_donations_data['today_donations'];

// Fetch total fundraising amount
$total_fundraising_query = "SELECT IFNULL(SUM(amount), 0) AS total_fundraised FROM fundraising_donations";
$total_fundraising_result = $conn->query($total_fundraising_query);
$total_fundraising_data = $total_fundraising_result->fetch_assoc();
$total_fundraised = $total_fundraising_data['total_fundraised'];

// Fetch today's fundraised amount (using `created_at` for fundraising_donations)
$today_fundraising_query = "SELECT IFNULL(SUM(amount), 0) AS today_fundraised FROM fundraising_donations WHERE DATE(created_at) = '$todayDate'";
$today_fundraising_result = $conn->query($today_fundraising_query);
$today_fundraising_data = $today_fundraising_result->fetch_assoc();
$today_fundraised = $today_fundraising_data['today_fundraised'];

// Close database connection
$conn->close();

// Generate table content with date included
$html = '
<h2>Dashboard Report</h2>
<p><b>Generated on:</b> ' . $reportDate . '</p>
<br>
<table border="1" cellspacing="3" cellpadding="5">
    <tr>
        <th><b>Category</b></th>
        <th><b>Value</b></th>
    </tr>
    <tr>
        <td>Total Pets</td>
        <td>' . $total_pets . '</td>
    </tr>
    <tr>
        <td>Adopted Pets</td>
        <td>' . $adopted_pets . '</td>
    </tr>
    <tr>
        <td>Total Donations (₱)</td>
        <td>' . number_format($total_donations, 2) . '</td>
    </tr>
    <tr>
        <td>Donations Today (₱)</td>
        <td>' . number_format($today_donations, 2) . '</td>
    </tr>
    <tr>
        <td>Total Fundraised (₱)</td>
        <td>' . number_format($total_fundraised, 2) . '</td>
    </tr>
    <tr>
        <td>Fundraised Today (₱)</td>
        <td>' . number_format($today_fundraised, 2) . '</td>
    </tr>
</table>
';

// Write the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF for download
$pdf->Output('Dashboard_Report_' . date('Ymd_His') . '.pdf', 'D'); // 'D' forces download

ob_end_flush(); // Prevents TCPDF output issues
