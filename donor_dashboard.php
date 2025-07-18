<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.html");
    exit();
}
$donor_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor Dashboard - BloodLink</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #3d464d;
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
            background-color: #d44431;
            padding: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
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
        .donor-name {
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
            background-color: #d44431;
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
                <div class="donor-name"><?php echo htmlspecialchars($donor_name); ?></div>
            </div>
            <div class="circle-group">
                <div class="initials"></div>
                <div class="initials"></div>
            </div>
        </div>
        <div class="description">
        We’re honored to have you as a lifesaver in our community. Your selfless donations are helping save lives every day. Here you can track your donation history, stay updated on upcoming drives, and see the lives you've impacted. Thank you for being the link that keeps hope alive. Let’s keep making a difference—one drop at a time.
        </div>
        <div class="button-group">
            <div class="button-row">
                <div class="circle"></div>
                <a href="donor_profile.php" class="btn">Profile</a>
            </div>
            <div class="button-row">
                <div class="circle"></div>
                <a href="upcoming_events.php" class="btn">Upcoming Events</a>
            </div>
            <div class="button-row">
                <div class="circle"></div>
                <a href="donation_history.php" class="btn">Donation History</a>
            </div>
        </div>
    </div>
    <div class="right-panel">
        <img src="bd.png" alt="Illustration" class="illustration">
    </div>
</div>
</body>
</html>
