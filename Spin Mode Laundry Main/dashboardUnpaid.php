<?php
include 'sql.php';

$date = $_POST['date'] ?? date('Y-m-d');


$stmt = $conn->prepare("SELECT COUNT(*) as count FROM status c 
                        JOIN history p ON c.ID = p.customer_id 
                        WHERE Payment = 'Unpaid' AND DATE(date) = ?");
$stmt->bind_param("s", $date);
$stmt->execute();
$countResult = $stmt->get_result();
$unpaidCount = $countResult->fetch_assoc()['count'] ?? 0;


$response = [
    'count' => $unpaidCount,
    'date' => $date
];

header('Content-Type: application/json');
echo json_encode($response);
?>