<?php
include 'sql.php';

$result = mysqli_query($conn, "SELECT * FROM user_logs ORDER BY timestamp DESC");

$logs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $logs[] = $row;
}

header('Content-Type: application/json');
echo json_encode($logs);
?>

