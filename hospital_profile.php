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

$sql = "SELECT hospital_id, hospital_name, hospital_email, hospital_phone, hospital_location FROM hospital WHERE hospital_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $hospital_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $hospital = $result->fetch_assoc();
} else {
    echo "No hospital found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Profile - BloodLink</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #91cbc8;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-container {
            width: 600px;
            background: #44476d;
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
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Hospital Profile</h2>
        <div class="profile-item"><strong>ID:</strong> <?php echo $hospital['hospital_id']; ?></div>
        <div class="profile-item"><strong>Name:</strong> <?php echo $hospital['hospital_name']; ?></div>
        <div class="profile-item"><strong>Email:</strong> <?php echo $hospital['hospital_email']; ?></div>
        <div class="profile-item"><strong>Phone:</strong> <?php echo $hospital['hospital_phone']; ?></div>
        <div class="profile-item"><strong>Location:</strong> <?php echo $hospital['hospital_location']; ?></div>
        
        <div class="btn-container">
            <a href="hospital_dashboard.php" class="dashboard-btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
