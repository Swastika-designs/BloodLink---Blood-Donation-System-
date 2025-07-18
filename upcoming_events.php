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

// Fetch donor ID
$donorQuery = "SELECT id FROM donor WHERE email = ?";
$stmt = $conn->prepare($donorQuery);
if (!$stmt) {
    die("SQL Error (donor query): " . $conn->error);
}
$stmt->bind_param("s", $user_email);
$stmt->execute();
$donorResult = $stmt->get_result();
$donor = $donorResult->fetch_assoc();
$donor_id = $donor['id'] ?? null;
$stmt->close();

if (!$donor_id) {
    die("Error: Donor not found.");
}

// Fetch upcoming events
$sql = "SELECT e.Event_Id, e.Event_Location, e.Event_Date, b.bank_name,
        (SELECT COUNT(*) FROM DonationRecord d WHERE d.Event_Id = e.Event_Id AND d.donor_id = ?) AS enrolled
        FROM DonationEvent e
        JOIN blood_bank b ON e.bank_id = b.bank_id
        WHERE e.Event_Date >= CURDATE()
        ORDER BY e.Event_Date ASC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error (event query): " . $conn->error);
}
$stmt->bind_param("i", $donor_id);

if (!$stmt->execute()) {
    die("SQL Execution Error: " . $stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upcoming Donation Events - BloodLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3d464d;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            background: #d44431;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
        }
        h2 {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            color: black;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #3d464d;
            color: white;
        }
        .enroll-btn {
            background-color: #28a745;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
        }
        .enroll-btn:hover {
            background-color: #218838;
        }
        .disabled-btn {
            background-color: #888;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upcoming Donation Events</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Event ID</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Organized By</th>
                    <th>Enroll</th>
                </tr>
                <?php while ($event = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['Event_Id']) ?></td>
                        <td><?= htmlspecialchars($event['Event_Location']) ?></td>
                        <td><?= htmlspecialchars($event['Event_Date']) ?></td>
                        <td><?= htmlspecialchars($event['bank_name']) ?></td>
                        <td>
                            <?php if ($event['enrolled'] > 0): ?>
                                <span class="disabled-btn">Enrolled</span>
                            <?php else: ?>
                                <a href="enroll_event.php?event_id=<?= $event['Event_Id'] ?>" class="enroll-btn">Enroll</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No upcoming events.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
