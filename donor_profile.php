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

$sql = "SELECT id, name, email, phone, blood_group, rh_factor, location, last_donation FROM donor WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $donor = $result->fetch_assoc();
} else {
    echo "No donor found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor Profile - BloodLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #3d464d;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-container {
            width: 600px;
            background: #d44431;
            padding: 25px;
            border-radius: 10px;
            text-align: left; 
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3);
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
    <div class="profile-container">
        <h2>Donor Profile</h2>
        <div class="profile-item"><strong>ID:</strong> <?php echo $donor['id']; ?></div>
        <div class="profile-item"><strong>Name:</strong> <?php echo $donor['name']; ?></div>
        <div class="profile-item"><strong>Email:</strong> <?php echo $donor['email']; ?></div>
        <div class="profile-item"><strong>Phone:</strong> <?php echo $donor['phone']; ?></div>
        <div class="profile-item"><strong>Blood Group:</strong> <?php echo $donor['blood_group']; ?></div>
        <div class="profile-item"><strong>Rh Factor:</strong> <?php echo $donor['rh_factor']; ?></div>
        <div class="profile-item"><strong>Location:</strong> <?php echo $donor['location']; ?></div>
        <div class="profile-item"><strong>Last Donation:</strong> <?php echo $donor['last_donation']; ?></div>
        
        <div class="btn-container">
            <a href="donor_dashboard.php" class="dashboard-btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
