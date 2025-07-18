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

$blood_bank_name = $_SESSION['user_name'];

// Ensure bank_id is set in session
if (!isset($_SESSION['bank_id'])) {
    $sql = "SELECT bank_id FROM blood_bank WHERE bank_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $blood_bank_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $_SESSION['bank_id'] = $row['bank_id'];
    } else {
        die("Error: Bank not found.");
    }
    $stmt->close();
}

$blood_bank_id = $_SESSION['bank_id'];

// Debugging: Ensure correct bank_id is set
// echo "Bank ID: " . $blood_bank_id; // Uncomment this line to check bank_id

// Fetch all events (past and upcoming) organized by the logged-in blood bank
$eventQuery = "SELECT Event_Id, Event_Location, Event_Date FROM DonationEvent WHERE bank_id = ?";
$stmt = $conn->prepare($eventQuery);
$stmt->bind_param("i", $blood_bank_id);
$stmt->execute();
$eventResult = $stmt->get_result();
$stmt->close();

// Check if events were fetched
if ($eventResult->num_rows == 0) {
    die("No events found for this blood bank.");
}

$donors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Fetch donors who participated in the selected event
    $donorQuery = "
        SELECT d.id, d.name, d.blood_group, d.rh_factor, d.phone, dr.Donation_Date 
        FROM DonationRecord dr
        JOIN Donor d ON dr.donor_id = d.id
        WHERE dr.Event_Id = ?";
    
    $stmt = $conn->prepare($donorQuery);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $donors[] = $row;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Donors - BloodLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #433e57;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #b9e1f1;
            padding: 20px;
            border-radius: 10px;
            color: black;
        }
        select, button {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            border: none;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
        }
        th {
            background: #b9e1f1;
        }
        .btn {
            background-color: #433e57;
            color: white;
            padding: 10px 15px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>View Donors for a Donation Event</h2>
        <form method="POST">
            <label>Select Event:</label>
            <select name="event_id" required>
                <option value="" disabled selected>Choose an Event</option>
                <?php while ($event = $eventResult->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($event['Event_Id']) ?>">
                        <?= htmlspecialchars($event['Event_Location']) ?> (<?= htmlspecialchars($event['Event_Date']) ?>)
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn">View Donors</button>
        </form>

        <?php if (!empty($donors)): ?>
            <h3>Donors for the Selected Event</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Blood Group</th>
                    <th>Rh Factor</th>
                    <th>Phone</th>
                    <th>Donation Date</th>
                </tr>
                <?php foreach ($donors as $donor): ?>
                    <tr>
                        <td><?= htmlspecialchars($donor['id']) ?></td>
                        <td><?= htmlspecialchars($donor['name']) ?></td>
                        <td><?= htmlspecialchars($donor['blood_group']) ?></td>
                        <td><?= htmlspecialchars($donor['rh_factor']) ?></td>
                        <td><?= htmlspecialchars($donor['phone']) ?></td>
                        <td><?= htmlspecialchars($donor['Donation_Date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
            <p>No donors found for the selected event.</p>
        <?php endif; ?>
        
        <a href="bloodbank_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
