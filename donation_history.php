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

$user_name = $_SESSION['user_name'];

// Get donor ID
$getIdSql = "SELECT id FROM donor WHERE name = ?";
$idStmt = $conn->prepare($getIdSql);
$idStmt->bind_param("s", $user_name);
$idStmt->execute();
$idResult = $idStmt->get_result();

if ($idResult->num_rows === 0) {
    echo "Donor not found.";
    exit();
}
$donor = $idResult->fetch_assoc();
$donor_id = $donor['id'];
$idStmt->close();

// Fetch full donation history with event and bank info
$sql = "
    SELECT dr.Record_Id, dr.Donation_Date,
           de.Event_Id, de.Event_Location, de.Event_Date,
           bb.bank_id, bb.bank_name, bb.bank_location
    FROM donationrecord dr
    JOIN donationevent de ON dr.Event_Id = de.Event_Id
    JOIN blood_bank bb ON de.bank_id = bb.bank_id
    WHERE dr.donor_id = ?
    ORDER BY dr.Donation_Date DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation History - BloodLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3d464d;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .history-container {
            width: 95%;
            max-width: 1000px;
            background: #d44431;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
        }
        h2 {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            background: white;
            color: black;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
            font-size: 15px;
        }
        th {
            background-color: #f8b8ac;
        }
        .btn-container {
            margin-top: 30px;
        }
        .dashboard-btn {
            background-color: #3d464d;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .dashboard-btn:hover {
            background-color: #2a2f33;
        }
    </style>
</head>
<body>
    <div class="history-container">
        <h2>Donation History</h2>
        <table>
            <tr>
                <th>Record ID</th>
                <th>Donation Date</th>
                <th>Event ID</th>
                <th>Event Location</th>
                <th>Event Date</th>
                <th>Bank ID</th>
                <th>Bank Name</th>
                <th>Bank Location</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Record_Id']) ?></td>
                        <td><?= htmlspecialchars($row['Donation_Date']) ?></td>
                        <td><?= htmlspecialchars($row['Event_Id']) ?></td>
                        <td><?= htmlspecialchars($row['Event_Location']) ?></td>
                        <td><?= htmlspecialchars($row['Event_Date']) ?></td>
                        <td><?= htmlspecialchars($row['bank_id']) ?></td>
                        <td><?= htmlspecialchars($row['bank_name']) ?></td>
                        <td><?= htmlspecialchars($row['bank_location']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No donation records found.</td></tr>
            <?php endif; ?>
        </table>

        <div class="btn-container">
            <a href="donor_dashboard.php" class="dashboard-btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
