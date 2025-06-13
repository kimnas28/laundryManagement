<?php
header('Content-Type: application/json');


include 'sql.php';


$data = json_decode(file_get_contents('php://input'), true);
$username = trim($data['username']);
$password = $data['password']; 


if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Username or password is empty.']);
    exit;
}


$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already exists.']);
    exit;
}


$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Insert failed.']);
}
$stmt->close();
$conn->close();
?>
