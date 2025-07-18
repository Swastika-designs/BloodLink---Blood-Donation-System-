<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['bank_id'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodlink";

// DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$blood_bank_id = $_SESSION['bank_id'];

// Handle status update if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'], $_POST['new_status'])) {
    $request_id = $_POST['request_id'];
    $new_status = $_POST['new_status'];

    $updateQuery = "UPDATE blood_requests SET status = ? WHERE request_id = ? AND bank_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sii", $new_status, $request_id, $blood_bank_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch requests
$requestQuery = "SELECT br.request_id, br.hospital_id, h.hospital_name, br.blood_group, br.quantity, 
                        COALESCE(br.status, 'pending') AS status, br.request_date 
                 FROM blood_requests br
                 JOIN hospital h ON br.hospital_id = h.hospital_id
                 WHERE br.bank_id = ?";
$stmt = $conn->prepare($requestQuery);
$stmt->bind_param("i", $blood_bank_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Management - BloodLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #433e57;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #b9e1f1;
            padding: 20px;
            border-radius: 10px;
            color: black;
        }
        h2 {
            margin-bottom: 30px;
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
        select {
            padding: 5px;
        }
        .btn {
            background-color: #433e57;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            border-radius: 5px;
        }
        form {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Request Management</h2>
        <table>
            <tr>
                <th>Hospital</th>
                <th>Blood Group</th>
                <th>Quantity</th>
                <th>Requested On</th>
                <th>Current Status</th>
                <th>Actions</th>
            </tr>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['hospital_name']) ?></td>
                        <td><?= htmlspecialchars($row['blood_group']) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td><?= date("d-M-Y H:i", strtotime($row['request_date'])) ?></td>
                        <td><?= ucfirst($row['status']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="request_id" value="<?= $row['request_id'] ?>">
                                <select name="new_status" onchange="this.form.submit()">
                                    <option disabled selected>Change Status</option>
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                    <option value="fulfilled">Fulfill</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No requests found.</td></tr>
            <?php endif; ?>
        </table>

        <a href="bloodbank_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
