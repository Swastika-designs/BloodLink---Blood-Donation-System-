<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost"; 
$username = "root";  
$password = "";  
$dbname = "bloodlink";  

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bank_name = $_SESSION['user_name'];

// Get blood bank ID
$sql = "SELECT bank_id FROM blood_bank WHERE bank_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $bank_name);
$stmt->execute();
$result = $stmt->get_result();
$bank = $result->fetch_assoc();
$bank_id = $bank['bank_id'];
$stmt->close();

// Fetch events
$sql = "SELECT * FROM DonationEvent WHERE bank_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $bank_id);
$stmt->execute();
$events = $stmt->get_result();
$stmt->close();

// Handle new event submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $event_location = $_POST['event_location'];
    $event_date = $_POST['event_date'];

    $sql = "INSERT INTO DonationEvent (Event_Id, bank_id, Event_Location, Event_Date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $event_id, $bank_id, $event_location, $event_date);

    if ($stmt->execute()) {
        header("Location: donation_events.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation Events - BloodLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #433e57;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #b9e1f1;
            color: black;
            padding: 20px;
            border-radius: 10px;
        }
        .btn {
            background-color: #433e57;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Donation Events</h2>
    <div class="container">
        <h3>Existing Events</h3>
        <ul>
            <?php while ($event = $events->fetch_assoc()): ?>
                <li><?php echo $event['Event_Location'] . " - " . $event['Event_Date']; ?></li>
            <?php endwhile; ?>
        </ul>

        <h3>Add New Event</h3>
        <form method="POST">
            <input type="number" name="event_id" placeholder="Event ID" required>
            <input type="text" name="event_location" placeholder="Event Location" required>
            <input type="date" name="event_date" required>
            <button type="submit" class="btn">Create Event</button>
        </form>
        <br>
        <a href="bloodbank_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
