<?php
include 'sql.php';

$date = $_POST['date'] ?? date('Y-m-d');


$stmt = $conn->prepare("SELECT COUNT(*) as count FROM status c 
                        JOIN history p ON c.ID = p.customer_id 
                        WHERE Status1 = 'Unclaimed' AND DATE(date) = ?");
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();
$unclaimedCount = $result->fetch_assoc()['count'] ?? 0;

header('Content-Type: application/json');
echo json_encode([
  'count' => $unclaimedCount,
  'date' => $date
]);
?>