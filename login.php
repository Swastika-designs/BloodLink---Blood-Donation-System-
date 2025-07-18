<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'bloodlink';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$email = trim($_POST['email']);
$input_password = trim($_POST['password']);
$role = trim($_POST['role']);

$table = '';
$name_field = ''; 
$password_field = '';
$email_field = '';

if ($role === 'donor') {
    $table = 'donor';
    $name_field = 'name';
    $password_field = 'password';
    $email_field = 'email';
} elseif ($role === 'bloodbank') {
    $table = 'blood_bank';
    $name_field = 'bank_name';
    $password_field = 'bank_password';
    $email_field = 'bank_email';
} elseif ($role === 'hospital') {
    $table = 'hospital';
    $name_field = 'hospital_name';
    $password_field = 'hospital_password';
    $email_field = 'hospital_email';
} else {
    die("Invalid role selected.");
}

// Prepare SQL query
if ($role === 'bloodbank') {
    // Include bank_id for blood banks
    $sql = "SELECT bank_id, $password_field, $name_field FROM $table WHERE $email_field = ?";
} else {
    $sql = "SELECT $password_field, $name_field FROM $table WHERE $email_field = ?";
}

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    if ($role === 'bloodbank') {
        $stmt->bind_result($bank_id, $db_password, $user_name);
    } else {
        $stmt->bind_result($db_password, $user_name);
    }

    $stmt->fetch();

    // Password check (use password_verify() if using hashes)
    if ($input_password === $db_password) {
        $_SESSION['user_name'] = $user_name;
        $_SESSION['role'] = $role;

        if ($role === 'donor') {
            $_SESSION['user_email'] = $email;
            header("Location: donor_dashboard.php");
        } elseif ($role === 'bloodbank') {
            $_SESSION['bank_id'] = $bank_id;
            header("Location: bloodbank_dashboard.php");
        } elseif ($role === 'hospital') {
            $_SESSION['hospital_name'] = $user_name;
            header("Location: hospital_dashboard.php");
        }
        exit();
    } else {
        die("Incorrect password.");
    }
} else {
    die("No user found.");
}

$stmt->close();
$conn->close();
?>
