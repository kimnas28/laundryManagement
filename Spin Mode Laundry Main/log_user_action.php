<?php
include 'sql.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$data = json_decode(file_get_contents("php://input"), true);

$username = $conn->real_escape_string($data['username']);
$action = $conn->real_escape_string($data['action']);  


$sql = "INSERT INTO user_logs (username, action) VALUES ('$username', '$action')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
