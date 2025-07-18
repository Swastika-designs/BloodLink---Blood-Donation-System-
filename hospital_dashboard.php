<?php
session_start();
if (!isset($_SESSION['hospital_name'])) {
    header("Location: login.html");
    exit();
}
$hospital_name = $_SESSION['hospital_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hospital Dashboard - BloodLink</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #91cbc8;
            color: white;
        }
        .container {
            display: flex;
            height: 100vh;
            padding: 40px;
            box-sizing: border-box;
        }
        .left-panel {
            flex: 1;
            padding: 20px;
        }
        .welcome-card {
            background-color: #44476d;
            padding: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            color: white;
        }
        .welcome-text {
            font-size: 20px;
            font-weight: bold;
            line-height: 1.4;
        }
        .circle-group {
            display: flex;
            gap: 5px;
        }
        .initials {
            width: 60px;
            height: 60px;
            background-color: white;
            border-radius: 50%;
        }
        .hospital-name {
            font-size: 16px;
            margin-top: 5px;
        }
        .description {
            background-color: #44476d; /* Set the background color here */
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.6;
            padding: 20px; /* Add some padding for better spacing */
            border-radius: 10px;
        }
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .button-row {
            display: flex;
            align-items: center;
        }
        .circle {
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 50%;
            margin-right: 10px;
        }
        .btn {
            background-color: #44476d;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .right-panel {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .illustration {
            max-height: 90%;
            max-width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left-panel">
        <div class="welcome-card">
            <div>
                <div class="welcome-text">Welcome to<br>BloodLink</div>
                <div class="hospital-name"><?php echo htmlspecialchars($hospital_name); ?></div>
            </div>
            <div class="circle-group">
                <div class="initials"></div>
                <div class="initials"></div>
            </div>
        </div>
        <div class="description">
            We’re proud to support your mission of saving lives every day. With BloodLink, you can efficiently manage blood inventories, track donations, and ensure timely transfusions for those in need. Thank you for being a critical part of the lifeline that connects donors to patients. Together, we’re making every drop count.
        </div>
        <div class="button-group">
            <div class="button-row">
                <div class="circle"></div>
                <a href="hospital_profile.php" class="btn">Profile</a>
            </div>
            <div class="button-row">
                <div class="circle"></div>
                <a href="hospital_request.php" class="btn">Requests</a>
            </div>
        </div>
    </div>
    <div class="right-panel">
        <img src="hos.png" alt="Illustration" class="illustration">
    </div>
</div>
</body>
</html>
