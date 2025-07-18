<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodlink";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$hospital_id = $_POST['hospital_id'];
$hospital_name = $_POST['hospital_name'];
$hospital_email = $_POST['hospital_email'];
$hospital_phone = $_POST['hospital_phone'];
$hospital_location = $_POST['hospital_location'];
$hospital_password = $_POST['hospital_password'];

// Insert into hospital table
$sql = "INSERT INTO hospital (hospital_id, hospital_name, hospital_email, hospital_phone, hospital_location, hospital_password) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $hospital_id, $hospital_name, $hospital_email, $hospital_phone, $hospital_location, $hospital_password);

if ($stmt->execute()) {
    // Redirect to success page on successful registration
    header("Location: success.html");
    exit();
} else {
    // Redirect to error page if there is an error
    header("Location: error.html");
    exit();
}

$stmt->close();
$conn->close();
?>