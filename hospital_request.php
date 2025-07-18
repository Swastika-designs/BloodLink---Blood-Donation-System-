<?php 
session_start();
if (!isset($_SESSION['hospital_name'])) {
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

$hospital_name = $_SESSION['hospital_name'];

// Get hospital ID
$sql = "SELECT hospital_id FROM hospital WHERE hospital_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hospital_name);
$stmt->execute();
$result = $stmt->get_result();
$hospital = $result->fetch_assoc();
$hospital_id = $hospital['hospital_id'];
$stmt->close();

// Fetch blood banks for dropdown
$banks = [];
$result = $conn->query("SELECT bank_id, bank_name FROM blood_bank");
while ($row = $result->fetch_assoc()) {
    $banks[] = $row;
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank_id = $_POST['bank_id'];
    $blood_group = $_POST['blood_group'];
    $quantity = $_POST['quantity'];

    if (empty($bank_id) || empty($blood_group) || empty($quantity)) {
        $message = "❗ Please fill in all fields.";
    } else {
        $sql = "INSERT INTO blood_requests (hospital_id, bank_id, blood_group, quantity) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisi", $hospital_id, $bank_id, $blood_group, $quantity);

        if ($stmt->execute()) {
            $message = "✅ Blood request submitted successfully.";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch past requests
$past_requests = [];
$sql = "SELECT br.*, bb.bank_name FROM blood_requests br 
        JOIN blood_bank bb ON br.bank_id = bb.bank_id 
        WHERE br.hospital_id = ? ORDER BY br.request_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hospital_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $past_requests[] = $row;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Blood - BloodLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #91cbc8;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-container, .requests-container {
            width: 600px;
            background: #44476d;
            padding: 25px;
            border-radius: 10px;
            text-align: left;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-top: 5px;
        }
        .submit-btn {
            background-color: #5ea3a3;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            margin-top: 25px;
            cursor: pointer;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #4c8b8b;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .dashboard-btn {
            background-color: #5ea3a3;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .dashboard-btn:hover {
            background-color: #4c8b8b;
        }
        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            color: white;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #5ea3a3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Request Blood</h2>
        <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>
        <form method="POST" action="">
            <label for="bank_id">Select Blood Bank:</label>
            <select name="bank_id" required>
                <option value="">-- Select --</option>
                <?php foreach ($banks as $bank): ?>
                    <option value="<?= $bank['bank_id'] ?>"><?= htmlspecialchars($bank['bank_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="blood_group">Blood Group:</label>
            <select name="blood_group" required>
                <option value="">-- Select --</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="quantity">Quantity (units):</label>
            <input type="number" name="quantity" min="1" required>

            <button type="submit" class="submit-btn">Submit Request</button>
        </form>

        <div class="btn-container">
            <a href="hospital_dashboard.php" class="dashboard-btn">Back to Dashboard</a>
        </div>
    </div>

    <div class="requests-container">
        <h2>Blood Request History</h2>
        <?php if (count($past_requests) == 0): ?>
            <p style="text-align:center;">No past requests found.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Bank</th>
                    <th>Blood Group</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Requested On</th>
                </tr>
                <?php foreach ($past_requests as $request): ?>
                    <tr>
                        <td><?= htmlspecialchars($request['bank_name']) ?></td>
                        <td><?= $request['blood_group'] ?></td>
                        <td><?= $request['quantity'] ?></td>
                        <td><?= $request['status'] ?></td>
                        <td><?= date("d-M-Y H:i", strtotime($request['request_date'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
