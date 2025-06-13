<?php
header('Content-Type: application/json');
include 'sql.php'; 

$result = $conn->query("SELECT username FROM users");

$accounts = [];
while ($row = $result->fetch_assoc()) {
    $accounts[] = $row['username'];
}

echo json_encode($accounts);

$conn->close();
?>
