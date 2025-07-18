<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodlink";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    header("Location: error.html");
    exit();
}

// Get form data
$bank_id = $_POST['bank_id'];
$bank_name = $_POST['bank_name'];
$bank_location = $_POST['bank_location'];
$bank_email = $_POST['bank_email'];
$bank_phone = $_POST['bank_phone'];
$bank_password = $_POST['bank_password']; // No hashing

// Prepare SQL statement
$sql = "INSERT INTO blood_bank (bank_id, bank_name, bank_location, bank_email, bank_phone, bank_password) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    header("Location: error.html");
    exit();
}

// Bind parameters
$stmt->bind_param("isssss", $bank_id, $bank_name, $bank_location, $bank_email, $bank_phone, $bank_password);

// Execute statement
if ($stmt->execute()) {
    header("Location: success.html");
} else {
    header("Location: error.html");
}

$stmt->close();
$conn->close();
exit();
?>
