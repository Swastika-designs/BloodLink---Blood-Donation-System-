<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    die("Error: User not logged in.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodlink";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_email = $_SESSION['user_email'];
$event_id = $_GET['event_id'];

// Fetch donor ID
$donorQuery = "SELECT id FROM donor WHERE email = ?";
$stmt = $conn->prepare($donorQuery);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$donorResult = $stmt->get_result();
$donor = $donorResult->fetch_assoc();
$donor_id = $donor['id'];
$stmt->close();

if (!$donor_id) {
    die("Error: Donor not found.");
}

// Insert into DonationRecord (enrollment)
$sql = "INSERT INTO DonationRecord (Event_Id, donor_id, Donation_Date) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $event_id, $donor_id);

if ($stmt->execute()) {
    // Redirect back to the upcoming events page with success message
    header("Location: upcoming_events.php?success=1");
    exit();
} else {
    die("Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
