<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.html");
    exit();
}
$bank_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Bank Dashboard - BloodLink</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #433e57;
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
            background-color: #b9e1f1;
            padding: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            color: black;
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
        .bank-name {
            font-size: 16px;
            margin-top: 5px;
        }
        .description {
            font-size: 14px;
            margin-bottom: 30px;
            line-height: 1.6;
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
            background-color: #b9e1f1;
            border: none;
            color: black;
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
                <div class="bank-name"><?php echo htmlspecialchars($bank_name); ?></div>
            </div>
            <div class="circle-group">
                <div class="initials"></div>
                <div class="initials"></div>
            </div>
        </div>
        <div class="description">
            We’re excited to have you as a key part of our lifesaving network. BloodLink empowers you to manage donations, monitor inventory in real-time, and coordinate efficiently with hospitals. Your role is essential in ensuring that every unit collected reaches those who need it most. Together, we’re the link that keeps hope flowing.
        </div>
        <div class="button-group">
            <div class="button-row">
                <div class="circle"></div>
                <a href="bloodbank_profile.php" class="btn">Profile</a>
            </div>
            <div class="button-row">
                <div class="circle"></div>
                <a href="bloodbank_request.php" class="btn">Requests</a>
            </div>
            <div class="button-row">
                <div class="circle"></div>
                <a href="blood_stock.php" class="btn">Blood Stock</a>
            </div>
            <div class="button-row">
                <div class="circle"></div>
                <a href="donation_events.php" class="btn">Donation Events</a>
            </div>
            <div class="button-row">
                <div class="circle"></div>
                <a href="event_donors.php" class="btn">Donor Participation</a>
            </div>
        </div>
    </div>
    <div class="right-panel">
        <img src="bloodbank.png" alt="Illustration" class="illustration">
    </div>
</div>
</body>
</html>
