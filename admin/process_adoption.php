<?php
session_start();

// Ensure this script runs only on a POST request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /SWS_v0/adoption-form.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "stray_worth_saving";
$port = 3306;

// Create database connection
$conn = new mysqli($servername, $username, $password, $database, $port);

if ($conn->connect_error) {
    $_SESSION['form_errors'] = ["Database connection failed."];
    header("Location: /SWS_v0/adoption-form.php");
    exit();
}

$errors = [];

// Required fields validation
$required_fields = [
    'first_name' => "First Name",
    'last_name' => "Last Name",
    'address' => "Address",
    'phone' => "Phone Number",
    'email' => "Email",
    'birthdate' => "Birth Date",
    'occupation' => "Occupation",
    'status' => "Status",
    'pronouns' => "Pronouns",
    'adopt_before' => "Adopt Before",
    'animal_interest' => "Animal of Interest"
];

foreach ($required_fields as $field => $label) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        $errors[] = "$label is required.";
    }
}

// Validate email format
if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}

// Validate checkboxes (terms & consent)
if (!isset($_POST['terms'])) {
    $errors[] = "You must agree to the Terms and Conditions.";
}
if (!isset($_POST['consent'])) {
    $errors[] = "You must consent to being contacted.";
}

// Validate at least one checkbox for "What prompted you to adopt?"
if (!isset($_POST['prompt']) || empty($_POST['prompt'])) {
    $errors[] = "Please select at least one reason for 'What prompted you to adopt from SWS?'.";
}

// If validation fails, redirect back with error messages
if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = $_POST; // Preserve user input
    header("Location: /SWS_v0/adoption-form.php");
    exit();
}

$submission_hash = md5(json_encode($_POST));

if (isset($_SESSION['last_submission']) && $_SESSION['last_submission'] == $submission_hash) {
    $_SESSION['form_errors'] = ["Document successfully submitted. Please reload the page."];
    header("Location: /SWS_v0/adoption-form.php");
    exit();
}

// Save hashed submission to prevent duplicates
$_SESSION['last_submission'] = $submission_hash;


// Sanitize form data
$first_name = $conn->real_escape_string(trim($_POST['first_name']));
$last_name = $conn->real_escape_string(trim($_POST['last_name']));
$address = $conn->real_escape_string(trim($_POST['address']));
$phone = $conn->real_escape_string(trim($_POST['phone']));
$email = $conn->real_escape_string(trim($_POST['email']));
$birthdate = $_POST['birthdate'];
$occupation = $conn->real_escape_string(trim($_POST['occupation']));
$status = $conn->real_escape_string(trim($_POST['status']));
$pronouns = $conn->real_escape_string(trim($_POST['pronouns']));
$adopt_before = $conn->real_escape_string(trim($_POST['adopt_before']));
$animal_interest = $conn->real_escape_string(trim($_POST['animal_interest']));
$terms_accepted = isset($_POST['terms']) ? 1 : 0;
$consent_given = isset($_POST['consent']) ? 1 : 0;
$prompted = isset($_POST['prompt']) ? implode(", ", array_map('htmlspecialchars', $_POST['prompt'])) : "";

// ✅ Insert into database using prepared statements (prevents SQL injection)
$stmt = $conn->prepare("INSERT INTO adoption_forms 
    (first_name, last_name, address, phone, email, birthdate, occupation, status, pronouns, prompted, animal_interest, adopt_before, terms_accepted, consent_given) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssssssssii", $first_name, $last_name, $address, $phone, $email, $birthdate, $occupation, $status, $pronouns, $prompted, $animal_interest, $adopt_before, $terms_accepted, $consent_given);

header('Content-Type: application/json');

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Your adoption form has been submitted successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Error submitting form. Please try again."]);
}

exit(); // No redirect!
