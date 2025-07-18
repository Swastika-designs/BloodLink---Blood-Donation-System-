<?php 
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodlink";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$blood_group = $_POST['blood_group'];
$rh_factor = $_POST['rh_factor'];
$location = trim($_POST['location']);
$last_donation = $_POST['last_donation'];
$plain_password = trim($_POST['password']); // Store plain text password

// Validate phone number format (optional)
if (!preg_match('/^\d{10}$/', $phone)) {
    die("Invalid phone number format.");
}

// Check if email or phone already exists
$check_query = "SELECT id FROM donor WHERE email = ? OR phone = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ss", $email, $phone);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("Error: Email or Phone already registered.");
}
$stmt->close();

// Insert into database using prepared statements
$sql = "INSERT INTO donor (name, email, phone, blood_group, rh_factor, location, last_donation, password) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $name, $email, $phone, $blood_group, $rh_factor, $location, $last_donation, $plain_password);

if ($stmt->execute()) {
    header("Location: success.html");
    exit();
} else {
    die("Registration failed: " . $conn->error);
}

$stmt->close();
$conn->close();
?>
