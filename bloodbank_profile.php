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

$sql = "SELECT bank_id, bank_name, bank_location, bank_email, bank_phone FROM blood_bank WHERE bank_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $bank_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $bloodbank = $result->fetch_assoc();
} else {
    echo "No blood bank found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Bank Profile - BloodLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #433e57;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-container {
            width: 600px;
            background: #b9e1f1;
            padding: 25px;
            border-radius: 10px;
            text-align: left; 
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
            color: black;
        }
        h2 {
            text-align: center;
            margin-bottom: 50px;
        }
        .profile-item {
            margin: 15px 0;
            font-size: 18px;
        }
        .btn-container {
            text-align: center;
            margin-top: 30px;
        }
        .dashboard-btn {
            background-color: #433e57;
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
    <div class="profile-container">
        <h2>Blood Bank Profile</h2>
        <div class="profile-item"><strong>ID:</strong> <?php echo $bloodbank['bank_id']; ?></div>
        <div class="profile-item"><strong>Name:</strong> <?php echo $bloodbank['bank_name']; ?></div>
        <div class="profile-item"><strong>Location:</strong> <?php echo $bloodbank['bank_location']; ?></div>
        <div class="profile-item"><strong>Email:</strong> <?php echo $bloodbank['bank_email']; ?></div>
        <div class="profile-item"><strong>Phone:</strong> <?php echo $bloodbank['bank_phone']; ?></div>
        
        <div class="btn-container">
            <a href="bloodbank_dashboard.php" class="dashboard-btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
