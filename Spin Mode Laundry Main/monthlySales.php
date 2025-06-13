<?php
include 'sql.php'; 

header('Content-Type: application/json');

$year = isset($_POST['year']) ? intval($_POST['year']) : date('Y');

$query = "SELECT 
            MONTH(date) AS month, 
            SUM(amount) AS total 
          FROM history 
          WHERE YEAR(date) = '$year' 
          GROUP BY month 
          ORDER BY month";

$result = $conn->query($query);

$data = array_fill(1, 12, 0); 

while ($row = $result->fetch_assoc()) {
    $month = (int)$row['month'];
    $total = (float)$row['total'];
    $data[$month] = $total;
}

echo json_encode(array_values($data)); 
?>
