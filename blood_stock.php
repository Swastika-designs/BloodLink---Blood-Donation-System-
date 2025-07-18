<?php
session_start();

// DEBUG: Uncomment to view session values during testing
// echo "Session Bank ID: " . $_SESSION['bank_id'] . "<br>";
// echo "Session Username: " . $_SESSION['user_name'] . "<br>";

if (!isset($_SESSION['user_name']) || !isset($_SESSION['bank_id'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodlink";

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get bank_id from session
$blood_bank_id = $_SESSION['bank_id'];

// Prepare and execute query
$stockQuery = "SELECT stock_id, bank_id, blood_type, quantity, expiry_date, status 
               FROM BloodStock 
               WHERE bank_id = ?";
$stmt = $conn->prepare($stockQuery);
$stmt->bind_param("i", $blood_bank_id);
$stmt->execute();
$result = $stmt->get_result();

// DEBUG: Uncomment to check row count
// echo "Rows found: " . $result->num_rows;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Stock - BloodLink</title>
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
        <h2>Blood Stock</h2>
        <table>
            <tr>
                <th>Stock ID</th>
                <th>Bank ID</th>
                <th>Blood Type</th>
                <th>Quantity</th>
                <th>Expiry Date</th>
                <th>Status</th>
            </tr>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['stock_id']) ?></td>
                        <td><?= htmlspecialchars($row['bank_id']) ?></td>
                        <td><?= htmlspecialchars($row['blood_type']) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td><?= htmlspecialchars($row['expiry_date']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No blood stock available.</td>
                </tr>
            <?php endif; ?>
        </table>

        <a href="bloodbank_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
