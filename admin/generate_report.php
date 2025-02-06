<?php
// Prevent unwanted output before PDF headers
ob_start(); 

require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

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

// Get the current date and time
$reportDate = date('F d, Y h:i A'); // Example: "February 04, 2025 10:30 AM"

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

// Fetch total fundraising amount
$total_fundraising_query = "SELECT IFNULL(SUM(amount), 0) AS total_fundraised FROM fundraising_donations";
$total_fundraising_result = $conn->query($total_fundraising_query);
$total_fundraising_data = $total_fundraising_result->fetch_assoc();
$total_fundraised = $total_fundraising_data['total_fundraised'];

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
        <td>Total Fundraised (₱)</td>
        <td>' . number_format($total_fundraised, 2) . '</td>
    </tr>
</table>
';

// Write the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF for download
$pdf->Output('Dashboard_Report_' . date('Ymd_His') . '.pdf', 'D'); // 'D' forces download

ob_end_flush(); // Prevents TCPDF output issues
?>
