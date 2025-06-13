<?php
session_start();

header('Content-Type: text/plain');
include 'sql.php';

$empnum = $_POST['empnum'];
$password = $_POST['password'];

if (empty($empnum) || empty($password)) {
    echo "Please enter both employee number and password.";
    exit;
}

$result = $conn->query("SELECT COUNT(*) AS total FROM users");
$row = $result->fetch_assoc();
if ($row['total'] == 0) {
    $defaultUser = 'admin';
    $defaultPass = 'admin123'; 
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $defaultUser, $defaultPass);
    $stmt->execute();
    $stmt->close();
}

$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $empnum);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $dbPassword = $row['password'];

    if ($password === $dbPassword) {
        $_SESSION['username'] = $empnum; 
        $log_sql = "INSERT INTO user_logs (username, action) VALUES ('$empnum', 'login')";
        $conn->query($log_sql);
        echo "success";
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>